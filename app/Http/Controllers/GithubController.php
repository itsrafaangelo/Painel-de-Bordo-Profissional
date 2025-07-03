<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function redirectToProvider()
    {
        $query = http_build_query([
            'client_id' => env('GITHUB_CLIENT_ID'),
            'redirect_uri' => env('GITHUB_REDIRECT_URI'),
            'scope' => 'repo notifications read:user read:org',
            'allow_signup' => 'true',
        ]);
        return redirect('https://github.com/login/oauth/authorize?' . $query);
    }

    public function handleProviderCallback(Request $request)
    {
        $response = Http::asForm()->post('https://github.com/login/oauth/access_token', [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'code' => $request->code,
            'redirect_uri' => env('GITHUB_REDIRECT_URI'),
        ]);
        parse_str($response->body(), $data);
        if (isset($data['access_token'])) {
            $user = Auth::user();
            if ($user && method_exists($user, 'save')) {
                $user->github_token = $data['access_token'];
                $user->save();
                return redirect()->route('dashboard')->with('success', 'GitHub conectado com sucesso!');
            }
        }
        return redirect()->route('dashboard')->with('error', 'Erro ao conectar com o GitHub.');
    }

    public static function getGithubData($user)
    {
        if (!$user->github_token) {
            return null;
        }
        $headers = [
            'Authorization' => 'token ' . $user->github_token,
            'Accept' => 'application/vnd.github.v3+json',
        ];
        // Notificações não lidas
        $notifications = \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->get('https://api.github.com/notifications?all=false&participating=false');
        $notificationsCount = is_array($notifications->json()) ? count($notifications->json()) : 0;
        // PRs para revisão
        $reviewRequests = \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->get('https://api.github.com/search/issues?q=is:pr+review-requested:@me+is:open');
        $reviewCount = $reviewRequests->json('total_count') ?? 0;
        // Últimos builds (status do workflow)
        $workflows = \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->get('https://api.github.com/user/repos?per_page=5');
        $lastBuilds = [];
        if (is_array($workflows->json())) {
            foreach (array_slice($workflows->json(), 0, 3) as $repo) {
                $runs = \Illuminate\Support\Facades\Http::withHeaders($headers)
                    ->get('https://api.github.com/repos/' . $repo['full_name'] . '/actions/runs?per_page=1');
                $run = $runs->json('workflow_runs.0');
                if ($run) {
                    $lastBuilds[] = [
                        'repo' => $repo['name'],
                        'status' => $run['conclusion'] ?? 'N/A',
                        'url' => $run['html_url'] ?? '#',
                    ];
                }
            }
        }
        return [
            'notifications' => $notificationsCount,
            'review_requests' => $reviewCount,
            'last_builds' => $lastBuilds,
        ];
    }
}

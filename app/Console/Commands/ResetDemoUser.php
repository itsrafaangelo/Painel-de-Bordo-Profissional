<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class ResetDemoUser extends Command
{
    protected $signature = 'demo:reset';
    protected $description = 'Reseta o usuário demo e apaga todos os seus dados (tarefas e projetos)';

    public function handle()
    {
        $user = User::where('email', 'demo@demo.com')->first();
        if ($user) {
            // Apaga projetos e tarefas do usuário demo
            Project::where('user_id', $user->id)->delete();
            Task::where('user_id', $user->id)->delete();
            $user->delete();
        }
        // Recria o usuário demo
        User::create([
            'name' => 'Usuário Demo',
            'email' => 'demo@demo.com',
            'password' => Hash::make('123456'),
        ]);
        $this->info('Usuário demo resetado com sucesso!');
    }
} 
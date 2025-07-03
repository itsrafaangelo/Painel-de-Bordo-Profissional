<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar usuário padrão para o sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Verificar se o usuário já existe
        $existingUser = User::where('email', 'rafael.mvieira7@gmail.com')->first();
        
        if ($existingUser) {
            $this->error('Usuário já existe!');
            return 1;
        }

        // Criar o usuário
        $user = User::create([
            'name' => 'Rafael',
            'email' => 'rafael.mvieira7@gmail.com',
            'password' => Hash::make('160607'),
        ]);

        $this->info('Usuário criado com sucesso!');
        $this->info('Email: rafael.mvieira7@gmail.com');
        $this->info('Senha: 160607');

        return 0;
    }
}

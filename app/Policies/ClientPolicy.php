<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;

class ClientPolicy
{
    public function view(User $user, Client $client)
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->houses->pluck('id')->contains($client->house_id);
    }

    public function update(User $user, Client $client)
    {
        return $this->view($user, $client);
    }

    public function delete(User $user, Client $client)
    {
        return $this->view($user, $client);
    }
}
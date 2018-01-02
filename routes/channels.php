<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{hash}', function ($user, $hash) {
    return ['ok' => App\Repository\MatchRepository::inMatch($user, $hash)];
});

Broadcast::channel('pair', function ($user) {
    return ['user' => $user];
});

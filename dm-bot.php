<?php
include __DIR__.'/vendor/autoload.php';
include 'config.php';
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Parts\Permissions;
use Discord\Builders\MessageBuilder;
use Discord\Parts\Interactions\Command\Command;
use Discord\Builders\CommandBuilder;
use Discord\Parts\Interactions\Interaction;
use Discord\Parts\User\Activity;
use Discord\Parts\Interactions\Command\Option;
use Discord\DiscordCommandClient;
use Discord\Parts\Interactions\Command\Permission;
use Discord\Parts\Embed\Embed;

// =========================    (18-30)                        

$discord = new Discord([
    'token' => $conf["token"],
]);

$discord->on('ready', function (Discord $discord) {
    $commands = [];

    $commands["ping"] = new Command($discord, ['name' => 'ping', 'description' => 'pong']);

    $commands["kick"] = new Command($discord, [
        'name' => 'kick', 
        'description' => '🚪 Wyrzuć kogoś z serwera organizacji!',
        'dm_permission' => false,
        'default_member_permissions' => (string) new Permission($discord, ['kick_members' => true]),
        'options' => [
            [
                'name'        => 'user',
                'description' => 'Kogo chcesz wyrzucić?',
                'type'        => Command::USER,
                'required'    => true,
            ]
        ]
    ]);

    $commands["warn"] = new Command($discord, [
        'name' => 'warn', 
        'description' => '❗ Ostrzeż kogoś za jego niepoprawne zachowanie!',
        'dm_permission' => false,
        'default_member_permissions' => (string) new Permission($discord, ['moderate_members' => true]),
        'options' => [
            [
                'name'        => 'user',
                'description' => 'Komu chcesz dać warna?',
                'type'        => Command::USER,
                'required'    => true,
            ]
        ]
    ]);



    foreach ($commands as $command){
        $discord->application->commands->save($command);
    }
    /*$discord->application->commands->save($discord->application->commands->create(CommandBuilder::new()
    ->setName('kick') 
    ->setDescription('🚪 Wyrzuć kogoś z serwera organizacji!')
    ->setDefaultMemberPermissions(new Permission($discord, ['kick_members' => true]))
    ->addOption((new Option($discord))
      ->setName('user')
      ->setDescription('Kogo chcesz wyrzucić?')
      ->setType(Option::USER)
      ->setRequired(true)
    )
    ->toArray()
    ));*/
    $discord->updatePresence(new Activity($discord, [
        'name' => 'Dark Moon',
        'type' => Activity::TYPE_WATCHING
    ]));
});



$




$discord->listenCommand('ping', function (Interaction $interaction) {
    $interaction->respondWithMessage(MessageBuilder::new()->setContent('Pong!'));
});

$discord->listenCommand('kick', function (Interaction $interaction) {
    $user = $interaction->data->resolved->users->first();
    $interaction->respondWithMessage(MessageBuilder::new()->setContent(":white_check_mark: **Pomyślnie wyrzucono {$user}!**"));
});

$discord->listenCommand('warn', function (Interaction $interaction) {
    $user = $interaction->data->resolved->users->first();
    $interaction->respondWithMessage(MessageBuilder::new()->setContent(":white_check_mark: **Pomyślnie wyrzucono {$user}!**"));
});

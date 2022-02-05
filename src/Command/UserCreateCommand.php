<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'user:create';
    protected static $defaultDescription = 'Permet de créer un utilisateur';

    private $entityManager;
    private UserPasswordHasher $hasher;


    // Ici on demande à Symfony de fournir les outils nécessaires
    public function __construct(
        string $name = null,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
        parent::__construct( $name );
    }

    // Arguments à fournir à l'appel de la commande
    protected function configure(): void
    {
        /**
         * 
         * $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
        */
    }

    // Ici le code de notre commande
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Phase de questions
        $helper = $this->getHelper('question');
        $email      = $helper->ask($input, $output, new Question("email: "));
        $firstname  = $helper->ask($input, $output, new Question("prénom: "));
        $lastname   = $helper->ask($input, $output, new Question("nom: "));
        $password   = $helper->ask($input, $output, new Question("password: "));
        dump($firstname);

        // Phase de vérifications
        if( $email !== null && 
            $firstname !== null &&
            $lastname !== null &&
            $password !== null ){

            $user = new User();
            $user   ->setEmail($email)
                    ->setFirstname($firstname)
                    ->setLastname($lastname);

            $hashedPassword = $this->hasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            

            $io->success('Utilisateur créé!');

        }else{
            $io->error('Les données sont invalides');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

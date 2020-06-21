<?php

namespace App\Command;

use App\Entity\Administrators;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdministratorCommand extends Command
{
    const LENGHT_PASSWORD = 10;
    protected static $defaultName = 'app:create-administrator';
    private $passwordEncoder;
    private $em;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add an administrator')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email user\'s')
            ->addArgument('firstname', InputArgument::OPTIONAL, 'Firstname user\'s')
            ->addArgument('lastname', InputArgument::OPTIONAL, 'Lastname user\'s')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $lastname = $input->getArgument('lastname');
        $firstname = $input->getArgument('firstname');

        if (!$email || !$lastname || !$firstname) {
            if (!$email) {
                $io->error('Missing argument: Email');
            }

            if (!$lastname) {
                $io->error('Missing argument: Lastname');
            }

            if (!$firstname) {
                $io->error('Missing argument: Firstname');
            }

            return Command::FAILURE;
        }

        $password = $this->generateRandomPassword();

        $administrators = new Administrators();
        $administrators
            ->setEmail($email)
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setPassword(
                $this->getEncodedPassword(
                    $administrators,
                    $password
                )
            )
            ->setRoles(['ROLE_ADMIN'])
            ->setIsVerified(true);

        $this->em->persist($administrators);
        $this->em->flush();

        $io->success('User create with password: ' . $password);

        return 0;
    }

    private function getEncodedPassword(Administrators $admin, $password) : string
    {
        return $this->passwordEncoder
            ->encodePassword($admin, $password);
    }

    private function generateRandomPassword () : string
    {
        $randomString = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lenghtMax = strlen($randomString);
        $randomPassword = '';
        for ($i = 0; $i < self::LENGHT_PASSWORD; $i++)
        {
            $randomPassword .= $randomString[rand(0, $lenghtMax - 1)];
        }

        return $randomPassword;
    }
}

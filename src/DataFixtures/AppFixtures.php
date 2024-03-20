<?php

namespace App\DataFixtures;

use App\Entity\AppUser;
use App\Entity\Contact;
use App\Entity\Organization;
use App\Entity\Reminder;
use App\Entity\Step;
use App\Entity\Talk;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $organization = new Organization();
            $organization->setName($faker->company);
            $organization->setStatus($faker->randomElement(['Active', 'Inactive', 'Pending']));
            $organization->setReferentName($faker->name);
            $organization->setReferentFunction($faker->jobTitle);
            $organization->setReferentMail($faker->email);
            $organization->setReferentPhone($faker->phoneNumber);

            for ($j = 0; $j < 5; $j++) {
                $step = new Step();
                $step->setPosition($j + 1);
                $step->setDescription($faker->randomElement([
                    'Établir premier contact',
                    'Rendez-vous de démonstration',
                    'Envoi du contrat',
                    'Définir le nombre de licences',
                    'Mise en place du logiciel',
                ]));
                $step->setColor($j < 2 ? 'green' : 'red');
                $step->setIsValidated($j < 2);
                $step->addOrganization($organization);

                $manager->persist($step);
            }

            $manager->persist($organization);
            for ($j = 0; $j < 3; $j++) {
                $contact = new Contact();
                $contact->setFirstName($faker->firstName);
                $contact->setLastName($faker->lastName);
                $contact->setEmail($faker->email);
                $contact->setPhone($faker->phoneNumber);
                $contact->setOrganization($organization);
                $contact->setNote($faker->text());

                $manager->persist($contact);
            }
            for ($j = 0; $j < 5; $j++) {
                $user = new AppUser();
                $user->setLastName($faker->lastName);
                $user->setFirstName($faker->firstName);
                $user->setLastLogin($faker->dateTimeThisYear);
                $user->setCreatedAt(new DateTimeImmutable());
                $user->setDeletedAt(new DateTimeImmutable());

                if ($organization->getStatus() === 'Active') {
                    $user->setStatus(AppUser::STATUS_ACTIVE);
                } else {
                    $user->setStatus($faker->randomElement([AppUser::STATUS_PENDING, AppUser::STATUS_INACTIVE]));
                }
                $user->setOrganization($organization);

                $manager->persist($user);
            }

            // Ajout de faux utilisateurs pour l'entité User
            for ($j = 0; $j < 5; $j++) {
                $user = new User();
                $user->setEmail($faker->email);
                $user->setFullName($faker->name);
                $user->setPassword('password');

                $manager->persist($user);
            }

            $manager->flush();
            for ($k = 0; $k < 2; $k++) {
                $talk = new Talk();
                $talk->setDatetime($faker->dateTimeThisMonth);
                $talk->setNote($faker->text());
                $talk->setOrganization($organization);

                $users = $manager->getRepository(AppUser::class)->findBy(['organization' => $organization]);

                $user = $faker->randomElement($users);
                $talk->setUser($user);

                $manager->persist($talk);
            }
            for ($j = 0; $j < 3; $j++) {
                $reminder = new Reminder();
                $reminder->setCreatedAt(new DateTimeImmutable());
                $reminder->setDueDate($faker->dateTimeThisMonth);
                $reminder->setNote($faker->sentence());
                $reminder->setOrganization($organization);

                $users = $manager->getRepository(AppUser::class)->findBy(['organization' => $organization]);

                $user = $faker->randomElement($users);
                $reminder->setUser($user);

                $manager->persist($reminder);
            }
        }

        $manager->flush();
    }
}
<?php

namespace App\Controller;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/create")
     */

    function createAdmin(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager):Response
    {
        $ad = new Admin();


        $ad->setFirstname('Richard');
        $ad->setLastname('Lionheart');
        $ad->setEmail('admin@gmail.com');
        $ad->setCreationDate(new \DateTime('now'));
        $ad->setRoles(['ADMIN_USER']);
        $ad->setAvatar('/public/images/admin.jfif');


        $passwordText = 'admin';
        $hashedPassword = $passwordHasher->hashPassword($ad,$passwordText);

        $ad->setPassword($hashedPassword);

        $entityManager->persist($ad);
        $entityManager->flush();

        return new Response('<body>admin crée</body>');
    }
}
<?php

namespace App\Entity;


use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
#[ApiResource]




class Admin extends User
{
}

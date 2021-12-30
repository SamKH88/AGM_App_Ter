<?php

namespace App\Form;

use App\Entity\Magasinier;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class RegistrationType
 * @package App\Form
 */
class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("userId", TextType::class, ["label" => "Identifiant","empty_data" => ""])
            ->add("pPassword", PasswordType::class, ["label" => "Mot de passe","empty_data" => ""])
            ->add("userNm", TextType::class, ["label" => "Nom","empty_data" => ""])
            ->add("userPre", TextType::class, ["label" => "Prénom","empty_data" => ""])
            ->add("userLocImb", TextType::class, ["label" => "Immeuble","empty_data" => ""])
            ->add("userLocEtage", TextType::class, ["label" => "Etage","empty_data" => ""])
            ->add("userLocPorte", TextType::class, ["label" => "Porte","empty_data" => ""])
            ->add("team", TextType::class, ["label" => "Equipe","empty_data" => ""]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Utilisateur::class);
    }
}

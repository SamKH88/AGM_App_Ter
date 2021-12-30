<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductType
 * @package App\Form
 */
class ProductType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("refPro", TextType::class, ["label" => "Référence du produit","empty_data" => ""])
            ->add("desPro", TextType::class, ["label" => "Description du produit","empty_data" => ""])
            ->add("condPro", TextType::class, ["label" => "Conditionnement","empty_data" => ""])
            ->add("qteSt", NumberType::class, ["attr" => ["min" => 1],"label" => "Quantité disponible en stock","empty_data" => ""])
            ->add("seuil", NumberType::class, ["label" => "Seuil minimal avant alerte","empty_data" => ""])
            ->add("datePer", DateType::class, ["label" => "Date d'expiration","empty_data" => ""])
            ->add("typePro", TextType::class, ["label" => "Type du produit","empty_data" => ""])
            ->add("position", TextType::class, ["label" => "Etagère de stockage","empty_data" => ""])
            ->add("fournPro", TextType::class, ["label" => "Fournisseur","empty_data" => ""]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Produit::class);
    }
}

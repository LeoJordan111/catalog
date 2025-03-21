<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\League;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Nom du club :',
                'required' => true,
            ])
            ->add('yearAt', null, [
                'label' => 'Année du maillot :',
                'widget' => 'single_text',
            ])
            // ->add('image', TextType::class, [
            //     'label' => "Lien de l'image :",
            //     'required' => true,
            // ])
            ->add('image', FileType::class, [
                'label' => "Lien de l'image :",
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix du maillot :',
                'required' => true,
            ])
            ->add('country', EntityType::class, [
                'label' => 'Pays du club :',
                'class' => Country::class,
                'choice_label' => 'label',
            ])
            ->add('league', EntityType::class, [
                'label' => 'Championnat du club :',
                'class' => League::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}

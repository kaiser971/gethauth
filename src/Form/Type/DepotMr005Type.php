<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;


class DepotMr005Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ipe', TextType::class, [
                'label' => 'IPE: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'ipe est obligatoire.']),
                ],
            ])
            ->add('finess', TextType::class, [
                'label' => 'N° FINESS: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La finess est obligatoire.']),
                ],
            ])
            ->add('raisonSociale', TextType::class, [
                'label' => 'Raison Sociale: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La raison sociale est obligatoire.']),
                ],
            ])
            ->add('civilite', ChoiceType::class, [
                'label' => 'Civilité: ',
                'choices' => [
                    'M' => 'Monsieur',
                    'Mme' => 'Madame',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La civilité est obligatoire.']),
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire.']),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le prenom est obligatoire.']),
                ],
            ])
            ->add('fonction', TextType::class, [
                'label' => 'Fonction: ',
                'attr' =>   [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La fonction est obligatoire.']),
                ],
            ])
            ->add('courriel', EmailType::class, [
                'label' => 'Courriel: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le courriel est obligatoire.']),
                    new Email(['message' => 'Le courriel est invalide.']),
                ],
            ])
            ->add('numeroRecepice', IntegerType::class, [
                'label' => 'Numéro de récépissé: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le numéro de récépissé est obligatoire.']),
                ],
            ])
            ->add('dateAtribution', DateType::class, [
                'label' => 'Date d\'attribution: ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date d\'attribution',
                    'data-format' => 'dd-mm-yyyy',
                ],
            ])
            ->add('fileType', FileType::class, [
                'label' => 'Transmission du récépissé: ',
                'mapped' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'cliquer pour déposer votre récépissé de MR005',
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer la demande de validation',
            ])
        ;
    }
}
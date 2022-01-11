<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class VideoFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filename',FileType::class,[
                "label"=> 'Video File'
            ])
            ->add('size')
            ->add('description')
            // ->add('author')
            // ->add('user')
            // ->add('format')
            // ->add('duration')
            ->add('title',TextType::class,[
                "data"=>'Write a blog post',
                'required'=>false
            ])

            ->add('created_at',DateType::class,[
                "label"=> "Set Date",
                "widget"=> "single_text"
            ])

            ->add('save',SubmitType::class)
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event){
            $video=$event->getData();
            $form=$event->getForm();
            if (!$video || null === $video->getId()){
                $form->add('created_at', DateType::class, [
                    'label'=>"Set date",
                     'widget'=>'single_text',
                ]);
            }
                
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}

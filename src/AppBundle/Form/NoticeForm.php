<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NoticeForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('notice', null, array(
                'label' => 'Заметка:',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Создать',
            ));
    }
}
<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskForm extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name', null, array(
					'label' => 'Задача:', 
					'attr' => array(
						'class' => 'form-control'
			)))
			->add('description', null, array(
					'label' => 'Описание:',
					'attr' => array(
							'class' => 'form-control'
					)		
			))
			->add('executeData', DateType::class, array(
					'label' => 'Дата:',
					'widget' => 'single_text',
					'attr' => array(
							'class' => 'form-control'
					)		
			))
			->add('category', EntityType::class, array(
			    'label' => 'Категория',
			    'class' => 'AppBundle:Category',
			    'choice_label' => 'name',
			    'placeholder' => 'Выберите категорию',
			    'attr' => array(
			        'class' => 'form-control'
			    )
			))
			->add('submit', SubmitType::class, array(
					'label' => 'Создать',
					'attr' => array(
							'class' => 'btn'
					)
			));
	}
}
<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Controller\ExecutedEnum;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReportForm extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('DateFrom', DateType::class, array(
					'label' => 'Нач. дата:',
					'widget' => 'single_text'
			))
			->add('DateTo', DateType::class, array(
					'label' => 'Кон. дата:',
					'widget' => 'single_text'
			))
			->add('isExecuted', ChoiceType::class, array(
					'choices' => array(
							'Выполненные' => ExecutedEnum::Executed,
							'Не выполненные' => ExecutedEnum::NoExecuted,
							'Все' => ExecutedEnum::All
					),
					'expanded' => 'true'
			))
			->add('submit', SubmitType::class, array(
					'label' => 'Показать'										
			));
	}
}
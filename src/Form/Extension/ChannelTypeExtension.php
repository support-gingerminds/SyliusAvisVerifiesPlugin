<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


final class ChannelTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isAvisVerifiesActive', CheckboxType::class, [
                'required' => true,
                'label' => 'ikuzo_avis_verifies.form.active',
            ])
            ->add('avisVerifiesSecretKey', TextType::class, [
                'required' => false,
                'label' => 'ikuzo_avis_verifies.form.secret_key',
            ])
            ->add('avisVerifiesWebsiteId', TextType::class, [
                'required' => false,
                'label' => 'ikuzo_avis_verifies.form.website_id',
            ])
            ->add('avisVerifiesDaysBeforeSent', ChoiceType::class, [
                'choices' => [
                    'ikuzo_avis_verifies.form.days.zero' => 0,
                    'ikuzo_avis_verifies.form.days.one' => 1,
                    'ikuzo_avis_verifies.form.days.two' => 2,
                    'ikuzo_avis_verifies.form.days.three' => 3,
                    'ikuzo_avis_verifies.form.days.four' => 4,
                    'ikuzo_avis_verifies.form.days.five' => 5,
                    'ikuzo_avis_verifies.form.days.six' => 6,
                    'ikuzo_avis_verifies.form.days.seven' => 7,
                    'ikuzo_avis_verifies.form.days.eight' => 8,
                    'ikuzo_avis_verifies.form.days.nine' => 9,
                    'ikuzo_avis_verifies.form.days.ten' => 10,
                    'ikuzo_avis_verifies.form.days.fifteen' => 15,
                    'ikuzo_avis_verifies.form.days.twenty' => 20,
                    'ikuzo_avis_verifies.form.days.twenty_five' => 25,
                    'ikuzo_avis_verifies.form.days.thirty' => 30,
                    'ikuzo_avis_verifies.form.days.fourty' => 40,
                ],
                'required' => true,
                'label' => 'ikuzo_avis_verifies.form.days_before_sent',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ChannelType::class];
    }
}
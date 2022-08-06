<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


final class ChannelTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isAvisVerifiesActive', CheckboxType::class, [
                'required' => true,
                'label' => 'ikuzo_avis_verifies.form.active',
            ])
            ->add('avisVerifiesSecretKey', PasswordType::class, [
                'required' => false,
                'label' => 'ikuzo_avis_verifies.form.secret_key',
            ])
            ->add('avisVerifiesWebsiteId', TextType::class, [
                'required' => false,
                'label' => 'ikuzo_avis_verifies.form.website_id',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ChannelType::class];
    }
}
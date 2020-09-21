<?php

namespace App\Form;

use App\Entity\Article;
//use Doctrine\DBAL\Types\IntegerType;
use App\Entity\SearchedArticle;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\Mapping\Id;
use phpDocumentor\Reflection\Types\AbstractList;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetArticleByIdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('name')
            //->add('price')
            //->add('description')
            //->add('stock')
            ->add('id', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchedArticle::class,
        ]);
    }
}

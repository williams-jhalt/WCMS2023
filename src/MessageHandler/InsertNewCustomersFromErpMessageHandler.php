<?php

namespace App\MessageHandler;

use App\Entity\Customer;
use App\Message\InsertNewCustomersFromErpMessage;
use App\Repository\CustomerRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class InsertNewCustomersFromErpMessageHandler
{

    public function __construct(
        private CustomerRepository $repo,
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(InsertNewCustomersFromErpMessage $message)
    {   

        $customers = $message->getCustomerData();

        $conn = $this->em->getConnection();
        
        $sql = "SELECT customer_number FROM customer";

        $knownItemNumbers = $conn->executeQuery($sql)->fetchFirstColumn();

        foreach ($customers as $customer) {

            if (array_search($customer['customer_number'], $knownItemNumbers) === false) {
                $c = new Customer();
                $c->setCustomerNumber($customer['customer_number']);
                $c->setCompany($customer['name']);
                $c->setAddress1($customer['address1']);
                $c->setAddress2($customer['address2']);
                $c->setCity($customer['city']);
                $c->setState($customer['state']);
                $c->setPostalCode($customer['postal_code']);
                $c->setCountry($customer['country_code']);
                $c->setAttention($customer['attention']);
                $c->setDateOpened(DateTimeImmutable::createFromFormat('Y-m-d', $customer['date_opened']));
                $this->em->persist($c);
            }

        }

        $this->em->flush();
        $this->em->clear();

    }
}
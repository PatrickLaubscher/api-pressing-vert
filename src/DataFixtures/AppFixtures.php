<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\AttributionPrestationCategory;
use App\Entity\Category;
use App\Entity\City;
use App\Entity\Civility;
use App\Entity\Customer;
use App\Entity\Employee;
use App\Entity\EmployeeStatus;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\OrderLineStatus;
use App\Entity\PaymentMode;
use App\Entity\Prestation;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    private const EMPLOYEES_NB = 4; 
    private const CUSTOMERS_NB = 30;
    private const ORDER_LINE_NB = 140;
    private const ORDER_NB = 50;

    private const EMPLOYEE_STATUS = ['Actif', 'Congés', 'Arrêt maladie', 'Supprimé'];

    private const PRESTATIONS = ['Repassage classique', 'Repassage et Reprisage', 'Repassage avec Tâches difficiles', 'Nettoyage du cuir', 'Blanchisserie'];

    private const CATEGORIES_MAIN = ['Vêtements', 'Tenues de cérémonies', 'Vêtements de travail', 'Linges de maison', 'Vêtements en cuir', 'Articles de maison'];
    private const PRODUCT_VETEMENTS0 = ['Chemise', 'Pantalon', 'Veste', 'Costume', 'Robe'];
    private const PRODUCT_CEREMONIES1 = ['Smoking', 'Robe de soirée', 'Robe de mariage'];
    private const PRODUCT_TRAVAIL2 = ['Blouse', 'Uniforme', 'Bleu de travail'];
    private const PRODUCT_BLANCHISSERIE3 = ['Dessus de lits', 'Couettes', 'Coussins'];
    private const PRODUCT_CUIR4 = ['Veste en cuir', 'Veste en daim'];
    private const PRODUCT_MAISON5 = ['Rideaux', 'Tapis'];

    private const CITIES = ['Lyon 1', 'Lyon 4', 'Caluire et Cuire'];
    private const CP = ['69001', '69004', '69300'];

    private const PAYMENT_MODE = ['Carte Bancaire', 'Virement', 'Paypal'];
    private const ORDER_STATUS = ['En attente', 'En cours', 'Terminée'];


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $civilities = [];
        $employees = [];
        $employeeStatusList = [];
        $categoriesMain = [];
        $prestations = [];
        $products = [];
        $statusOrder = [];
        $paymentModes = [];
        $orders = [];

        $cities = [];
        $customers = [];


        $civility = new Civility();
        $civility
            ->setName('Monsieur')
            ->setAbreviation('M.');
        $civilities[] = $civility;
        $manager->persist($civility);

        $civility = new Civility();
        $civility
            ->setName('Madame')
            ->setAbreviation('Mme');
        $civilities[] = $civility;
        $manager->persist($civility);

        for($i=0; $i < 3; $i++) {
            $city = new City();
            $city
                ->setName(SELF::CITIES[$i])
                ->setZipCode(SELF::CP[$i]);
            $manager->persist($city);
            $cities[] = $city;
        }
        
        $adminUser = new Admin();
        $adminUser
            ->setEmail('bernardAdmin@auplivert.com')
            ->setCivility($civilities[0])
            ->setLastname('Durand')
            ->setFirstname('Bernard')
            ->setPhone('0000000000')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword("admin");
        $manager->persist($adminUser);

        foreach (SELF::EMPLOYEE_STATUS as $status) {
            $employeeStatus = new EmployeeStatus();
            $employeeStatus->setName($status);
            $manager->persist($employeeStatus);
            $employeeStatusList[] = $employeeStatus;
        }
        
        for($i=0; $i < SELF::EMPLOYEES_NB; $i++){
            $employee = new Employee();
            $employee
                ->setEmail($faker->safeEmail())
                ->setCivility($faker->randomElement($civilities))
                ->setLastname($faker->word())
                ->setFirstname($faker->word())
                ->setPhone('0000000000')
                ->setRoles(['ROLE_EMPLOYEE'])
                ->setCreationDate($faker->dateTimeBetween('-3 years', '-3 weeks'))
                ->setEmployeeStatus($employeeStatusList[0])
                ->setPassword("employee");
            $manager->persist($employee);
            $employees[] = $employee;
        }

        $employee = new Employee();
        $employee
            ->setEmail('marie@auplivert.com')
            ->setCivility($civilities[1])
            ->setLastname('Chevalier')
            ->setFirstname('Marie')
            ->setPhone('0000000000')
            ->setRoles(['ROLE_EMPLOYEE'])
            ->setCreationDate($faker->dateTimeBetween('-3 years', '-3 weeks'))
            ->setEmployeeStatus($employeeStatusList[0])
            ->setPassword("employee");
        $manager->persist($employee);
        $employees[] = $employee;

        for($i=0; $i < SELF::CUSTOMERS_NB; $i++){
            $customer = new Customer();
            $customer
                ->setEmail($faker->safeEmail())
                ->setCivility($faker->randomElement($civilities))
                ->setLastname($faker->word())
                ->setFirstname($faker->word())
                ->setPhone('0000000000')
                ->setRoles(['ROLE_CUSTOMER'])
                ->setCity($faker->randomElement($cities))
                ->setAddress($faker->sentence())
                ->setCreationDate($faker->dateTimeBetween('-3 years', '-3 weeks'))
                ->setPassword("customer");
            $manager->persist($customer);
            $customers[] = $customer;
        }

        $customer = new Customer();
        $customer
            ->setEmail('test@client.com')
            ->setCivility($faker->randomElement($civilities))
            ->setLastname($faker->word())
            ->setFirstname($faker->word())
            ->setPhone('0000000000')
            ->setRoles(['ROLE_CUSTOMER'])
            ->setCity($faker->randomElement($cities))
            ->setAddress($faker->sentence())
            ->setCreationDate($faker->dateTimeBetween('-3 years', '-3 weeks'))
            ->setPassword("customer");
        $manager->persist($customer);
        $customers[] = $customer;
        
        
        foreach(SELF::PRESTATIONS as $prestationName) {
            $prestation = new Prestation();
            $prestation 
                ->setName($prestationName)
                ->setBasePrice(1);
            $manager->persist($prestation);
            $prestations[] = $prestation;
        }
        
        foreach(SELF::CATEGORIES_MAIN as $categorieName) {
            $categorie = new Category();
            $categorie
                ->setName($categorieName)
                ->setCoefPrice(1);
            $manager->persist($categorie);
            $categoriesMain[] = $categorie;
        }

        foreach(SELF::PRODUCT_VETEMENTS0 as $vetementName) {
            $vetement = new Product();
            $vetement
                ->setName($vetementName)
                ->setCategory($categoriesMain[0])
                ->setCoefPrice(1);
            $manager->persist($vetement);
            $products[] = $vetement;
        }

        foreach(SELF::PRODUCT_CEREMONIES1 as $vetCeremoniesName) {
            $vetCeremonies = new Product();
            $vetCeremonies
                ->setName($vetCeremoniesName)
                ->setCategory($categoriesMain[1])
                ->setCoefPrice(1);
            $manager->persist($vetCeremonies);
            $products[] = $vetCeremonies;
        }

        foreach(SELF::PRODUCT_TRAVAIL2 as $vetTravailName) {
            $vetTravail = new Product();
            $vetTravail
                ->setName($vetTravailName)
                ->setCategory($categoriesMain[2])
                ->setCoefPrice(1);
            $manager->persist($vetTravail);
            $products[] = $vetTravail;
        }

        foreach(SELF::PRODUCT_BLANCHISSERIE3 as $blanchisserieName) {
            $blanchisserie = new Product();
            $blanchisserie
                ->setName($blanchisserieName)
                ->setCategory($categoriesMain[3])
                ->setCoefPrice(1);
            $manager->persist($blanchisserie);
            $products[] = $blanchisserie;
        }

        foreach(SELF::PRODUCT_CUIR4 as $cuirName) {
            $Vetcuir = new Product();
            $Vetcuir
                ->setName($cuirName)
                ->setCategory($categoriesMain[4])
                ->setCoefPrice(1);
            $manager->persist($Vetcuir);
            $products[] = $Vetcuir;
        }

        foreach(SELF::PRODUCT_MAISON5 as $articleMaisonName) {
            $articleMaison = new Product();
            $articleMaison
                ->setName($articleMaisonName)
                ->setCategory($categoriesMain[5])
                ->setCoefPrice(1);
            $manager->persist($articleMaison);
            $products[] = $articleMaison;
        }

        /* Attribution Vêtements */

        for($i=0; $i < 2; $i++){
            $attributionPrestationCategory = new AttributionPrestationCategory();
            $attributionPrestationCategory
                ->addPrestation($prestations[0])
                ->addCategory($categoriesMain[$i]);

            $manager->persist($attributionPrestationCategory);
        }

        for($i=0; $i < 2; $i++){
            $attributionPrestationCategory = new AttributionPrestationCategory();
            $attributionPrestationCategory
                ->addPrestation($prestations[1])
                ->addCategory($categoriesMain[$i]);

            $manager->persist($attributionPrestationCategory);
        }


        for($i=0; $i < 2; $i++){
            $attributionPrestationCategory = new AttributionPrestationCategory();
            $attributionPrestationCategory
                ->addPrestation($prestations[2])
                ->addCategory($categoriesMain[$i]);

            $manager->persist($attributionPrestationCategory);
        }


        /* Attribution Cuir */

        $attributionPrestationCategory = new AttributionPrestationCategory();
        $attributionPrestationCategory
            ->addPrestation($prestations[3])
            ->addCategory($categoriesMain[4]);

        $manager->persist($attributionPrestationCategory);
      


        /* Attribution Blanchisserie */

        $attributionPrestationCategory = new AttributionPrestationCategory();
        $attributionPrestationCategory
            ->addPrestation($prestations[4])
            ->addCategory($categoriesMain[3]);

        $manager->persist($attributionPrestationCategory);


        /* Attribution Articles de maison */

        $attributionPrestationCategory = new AttributionPrestationCategory();
        $attributionPrestationCategory
            ->addPrestation($prestations[0])
            ->addCategory($categoriesMain[5]);

        $manager->persist($attributionPrestationCategory);
        

        $attributionPrestationCategory = new AttributionPrestationCategory();
        $attributionPrestationCategory
            ->addPrestation($prestations[1])
            ->addCategory($categoriesMain[5]);

        $manager->persist($attributionPrestationCategory);


        $attributionPrestationCategory = new AttributionPrestationCategory();
        $attributionPrestationCategory
            ->addPrestation($prestations[2])
            ->addCategory($categoriesMain[5]);

        $manager->persist($attributionPrestationCategory);




        foreach(SELF::PAYMENT_MODE as $paymentModeName) {
            $paymentMode = new PaymentMode();
            $paymentMode
                ->setName($paymentModeName);
            $manager->persist($paymentMode);
            $paymentModes[] = $paymentMode;
        }

        foreach(SELF::ORDER_STATUS as $orderStatusName) {
            $orderStatus = new OrderLineStatus();
            $orderStatus
                ->setName($orderStatusName);
            $manager->persist($orderStatus);
            $statusOrder[] = $orderStatus;
        }


        for($i=0; $i < SELF::ORDER_NB; $i++) {
            $order = new Order();
            $order
                ->setCustomer($faker->randomElement($customers))
                ->setPaymentMode($faker->randomElement($paymentModes))
                ->setDepositDate($faker->dateTimeBetween('-3 years', 'now'))
                ->setDate($faker->dateTimeBetween('-3 years', 'now'));
            $manager->persist($order);
            $orders[] = $order;
        }

        for($i=0; $i < SELF::ORDER_LINE_NB; $i++) {
            $orderLine = new OrderLine();
            $orderLine
                ->setProduct($faker->randomElement($products))
                ->setPrestation($faker->randomElement($prestations))
                ->setMainOrder($faker->randomElement($orders))
                ->setOrderLineStatus($faker->randomElement($statusOrder))
                ->setEmployee($faker->randomElement($employees))
                ->setQty($faker->numberBetween(1,6))
                ->setPrice($faker->numberBetween(20,80));
            $manager->persist($orderLine);
        }

        for($i=0; $i < 12; $i++) {
            $orderLine = new OrderLine();
            $orderLine
                ->setProduct($faker->randomElement($products))
                ->setPrestation($faker->randomElement($prestations))
                ->setMainOrder($faker->randomElement($orders))
                ->setOrderLineStatus($statusOrder[0])
                ->setQty($faker->numberBetween(1,6))
                ->setPrice($faker->numberBetween(20,80));
            $manager->persist($orderLine);
        }

        $manager->flush();
    }
}

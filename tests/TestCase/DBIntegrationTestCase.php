<?php

namespace App\Tests\TestCase;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;

class DBIntegrationTestCase extends SymfonyWebTestCase
{
    /* @var EntityManager */
    protected $entityManager;

    static private $dbSchema;

    public function setUp() : void
    {
        parent::setUp();
        $this->initializeKernel();
        $this->initializeDatabase();
    }

    public function initializeKernel()
    {
        static::$kernel = self::bootKernel();
    }

    public function initializeDatabase()
    {
        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $connection = $this->entityManager->getConnection();
        $connection->getConfiguration()->setSQLLogger(null);

        $schemaTool = new SchemaTool($this->entityManager);

        if ( !self::$dbSchema ) {
            $dbMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
            self::$dbSchema = $schemaTool->getCreateSchemaSql($dbMetadata);
        }

        foreach ( self::$dbSchema as $sql) {
            try {
                $connection->executeQuery($sql);
            } catch( \Exception $e ) {}
        }
    }

    public function tearDown() : void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function get($service)
    {
        //return self::$container->get($service);
        return static::$kernel->getContainer()->get($service);
    }

}
<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\MemberSummary\JobExperience;
use AppBundle\Entity\MemberSummary\Language;
use AppBundle\Entity\MemberSummary\MissionType;
use AppBundle\Entity\MemberSummary\Skill;
use AppBundle\Entity\MemberSummary\Training;
use AppBundle\Summary\Contract;
use AppBundle\Summary\Contribution;
use AppBundle\Summary\JobDuration;
use AppBundle\Summary\JobLocation;
use AppBundle\Summary\SummaryFactory;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSummaryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $summaryFactory = $this->getSummaryFactory();

        $summary1 = $summaryFactory->createFromArray([
            'adherent' => $manager->getRepository(Adherent::class)->findByUuid(LoadAdherentData::ADHERENT_1_UUID),
            'slug' => 'michelle-dufour',
            'availabilities' => [JobDuration::PART_TIME],
            'contactEmail' => 'michelle.dufour.2@example.ch',
            'contributionWish' => Contribution::VOLUNTEER,
            'jobLocations' => [JobLocation::ON_REMOTE],
            'motivation' => 'C\'est mon secret',
            'professionalSynopsis' => '30 ans de travail dans le domaine scientifique',
            'currentProfession' => 'Bio-informaticien',
            'websiteUrl' => 'https://michelle-dufour-fake.en-marche-dev.fr',
            'viadeoUrl' => 'https://fr.viadeo.com/michelle-dufour-fake',
            'facebookUr' => 'https://www.facebook.com/michelle-dufour-fake',
            'twitterNickname' => 'https://twitter.com/michelle-dufour-fake',
            'missionWishes' => $manager->getRepository(MissionType::class)->findBy(['name' => 'Missions de bénévolat']),
        ]);
        $manager->persist($summary1);

        // Experiances
        $experience11 = new JobExperience();
        $experience11->setCompany('Institut KNURE');
        $experience11->setDescription('Bio-informaticien dans l\'institut KNURE');
        $experience11->setOnGoing(true);
        $experience11->setStartedAt(new \DateTime('2007-04-28 00:00:00'));
        $experience11->setDisplayOrder(1);
        $experience11->setCompanyFacebookPage('https://www.facebook.com/khure-fake');
        $experience11->setCompanyTwitterNickname('khureBioInformatique');
        $experience11->setContract(Contract::PERMANENT);
        $experience11->setDuration(JobDuration::FULL_TIME);
        $experience11->setLocation('Genève');
        $experience11->setPosition('Bio-informaticien');
        $experience11->setWebsite('http://khure.bioinformatique.ch');
        $experience11->setSummary($summary1);
        $manager->persist($experience11);

        $experience12 = new JobExperience();
        $experience12->setCompany('Univérsité Lyon 1');
        $experience12->setDescription('Professeur à l\'université');
        $experience12->setOnGoing(false);
        $experience12->setStartedAt(new \DateTime('1995-10-26 00:00:00'));
        $experience12->setEndedAt(new \DateTime('2006-01-26 00:00:00'));
        $experience12->setDisplayOrder(2);
        $experience12->setCompanyFacebookPage('https://www.facebook.com/lyon1-fake');
        $experience12->setCompanyTwitterNickname('lyon1-fake');
        $experience12->setContract(Contract::PERMANENT);
        $experience12->setDuration(JobDuration::FULL_TIME);
        $experience12->setLocation('Lyon');
        $experience12->setPosition('Professeur');
        $experience12->setWebsite('http://lyon.bioinformatique.fr');
        $experience12->setSummary($summary1);
        $manager->persist($experience12);

        // Trainings
        $training11 = new Training();
        $training11->setDescription('Master en Bio-Informatique');
        $training11->setOrganization('Lyon 1');
        $training11->setDiploma('Diplôme d\'ingénieur');
        $training11->setDisplayOrder(1);
        $training11->setStartedAt(new \DateTime('1993-09-01 00:00:00'));
        $training11->setEndedAt(new \DateTime('1995-10-01 00:00:00'));
        $training11->setOnGoing(false);
        $training11->setStudyField('Bio-Informatique');
        $training11->setSummary($summary1);
        $manager->persist($training11);

        $training12 = new Training();
        $training12->setDescription('Génie biologique option Bio-Informatique');
        $training12->setOrganization('Lyon 1');
        $training12->setDiploma('DUT Génie biologique');
        $training12->setDisplayOrder(2);
        $training11->setExtracurricular('Les activités musicales');
        $training12->setStartedAt(new \DateTime('1990-09-01 00:00:00'));
        $training12->setEndedAt(new \DateTime('1992-10-01 00:00:00'));
        $training12->setOnGoing(false);
        $training12->setStudyField('Bio-Informatique');
        $training12->setSummary($summary1);
        $manager->persist($training12);

        // Languages
        $language11 = new Language();
        $language11->setCode('fr');
        $language11->setLevel(Language::LEVEL_FLUENT);
        $language11->setSummary($summary1);
        $manager->persist($language11);

        $language12 = new Language();
        $language12->setCode('en');
        $language12->setLevel(Language::LEVEL_HIGH);
        $language12->setSummary($summary1);
        $manager->persist($language12);

        $language13 = new Language();
        $language13->setCode('es');
        $language13->setLevel(Language::LEVEL_MEDIUM);
        $language13->setSummary($summary1);
        $manager->persist($language13);

        // Skills
        $skill11 = new Skill();
        $skill11->setName('Software');
        $skill11->setSummary($summary1);
        $manager->persist($skill11);

        $skill12 = new Skill();
        $skill12->setName('Analyze');
        $skill12->setSummary($summary1);
        $manager->persist($skill12);

        $skill13 = new Skill();
        $skill13->setName('Mathématiques');
        $skill13->setSummary($summary1);
        $manager->persist($skill13);

        $skill14 = new Skill();
        $skill14->setName('Statistique');
        $skill14->setSummary($summary1);
        $manager->persist($skill14);

        $summary2 = $summaryFactory->createFromArray([
            'adherent' => $manager->getRepository(Adherent::class)->findByUuid(LoadAdherentData::ADHERENT_2_UUID),
            'slug' => 'carl-mirabeau',
            'availabilities' => [JobDuration::PUNCTUALLY],
            'contactEmail' => 'carl9992@example.fr',
            'contributionWish' => Contribution::CONTRACTOR,
            'jobLocations' => [JobLocation::ON_REMOTE],
            'motivation' => 'Je le veux !',
            'professionalSynopsis' => 'Travail en média',
            'currentProfession' => 'Aucun',
            'websiteUrl' => 'https://carl-mirabeau-fake.en-marche-dev.fr',
            'viadeoUrl' => 'https://fr.viadeo.com/carl-mirabeau-fake',
            'facebookUr' => 'https://www.facebook.com/carl-mirabeau-fake',
            'twitterNickname' => 'https://twitter.com/carl-mirabeau-fake',
            'missionWishes' => $manager->getRepository(MissionType::class)->findBy(['name' => 'Action publique']),
        ]);
        $manager->persist($summary2);

        // Trainings
        $training21 = new Training();
        $training21->setDescription('Master en Média - Audiovisuel');
        $training21->setOrganization('Clermont');
        $training21->setDiploma('Master en Média');
        $training21->setDisplayOrder(1);
        $training21->setStartedAt(new \DateTime('2013-09-01 00:00:00'));
        $training21->setEndedAt(new \DateTime('2016-09-01 00:00:00'));
        $training21->setOnGoing(false);
        $training21->setStudyField('Média');
        $training21->setSummary($summary2);
        $manager->persist($training21);

        // Languages
        $language21 = new Language();
        $language21->setCode('fr');
        $language21->setLevel(Language::LEVEL_FLUENT);
        $language21->setSummary($summary2);
        $manager->persist($language21);

        $language22 = new Language();
        $language22->setCode('en');
        $language22->setLevel(Language::LEVEL_MEDIUM);
        $language22->setSummary($summary2);
        $manager->persist($language22);

        $language23 = new Language();
        $language23->setCode('zh');
        $language23->setLevel(Language::LEVEL_BASIC);
        $language23->setSummary($summary2);
        $manager->persist($language23);

        // Skills
        $skill21 = new Skill();
        $skill21->setName('Ecriture médiatique');
        $skill21->setSummary($summary2);
        $manager->persist($skill21);

        $skill22 = new Skill();
        $skill22->setName('Gestion des relations');
        $skill22->setSummary($summary2);
        $manager->persist($skill22);

        $skill23 = new Skill();
        $skill23->setName('Culture de l’image');
        $skill23->setSummary($summary2);
        $manager->persist($skill23);

        $skill24 = new Skill();
        $skill24->setName('Outils médias');
        $skill24->setSummary($summary2);
        $manager->persist($skill24);

        $summary3 = $summaryFactory->createFromArray([
            'adherent' => $manager->getRepository(Adherent::class)->findByUuid(LoadAdherentData::ADHERENT_3_UUID),
            'slug' => 'jacques-picard',
            'availabilities' => [JobDuration::FULL_TIME],
            'contactEmail' => 'jacques.picard@en-marche.fr',
            'contributionWish' => Contribution::EMPLOYEE,
            'jobLocations' => [JobLocation::ON_SITE],
            'motivation' => 'Je suis motivé',
            'professionalSynopsis' => 'Travaillé dans differents domaines.',
        ]);
        $manager->persist($summary3);

        $manager->flush();
    }

    private function getSummaryFactory(): SummaryFactory
    {
        return new SummaryFactory(new Slugify());
    }
}

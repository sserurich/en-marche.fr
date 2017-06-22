<?php

namespace AppBundle\Summary;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\MemberSummary\JobExperience;
use AppBundle\Entity\Summary;
use AppBundle\Repository\SummaryRepository;
use Doctrine\Common\Persistence\ObjectManager;

class SummaryManager
{
    private $factory;
    private $repository;
    private $manager;

    public function __construct(SummaryFactory $factory, SummaryRepository $repository, ObjectManager $manager)
    {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function getForAdherent(Adherent $adherent): Summary
    {
        if ($summary = $this->repository->findOneForAdherent($adherent)) {
            return $summary;
        }

        return $this->factory->createFromAdherent($adherent);
    }

    public function handleExperience(Summary $summary, JobExperience $experience): void
    {
        $summary->addExperience($experience);

        $this->updateSummary($summary);
    }

    private function updateSummary(Summary $summary): void
    {
        if (!$summary->getId()) {
            $this->manager->persist($summary);
        }

        $this->manager->flush();
    }
}

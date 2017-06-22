<?php

namespace AppBundle\Controller\EnMarche;

use AppBundle\Controller\CanaryControllerTrait;
use AppBundle\Entity\MemberSummary\JobExperience;
use AppBundle\Form\JobExperienceType;
use AppBundle\Summary\SummaryManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/espace-adherent/mon-cv")
 */
class SummaryManagerController extends Controller
{
    use CanaryControllerTrait;

    /**
     * @Route(name="app_summary_manager_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->disableInProduction();

        return $this->render('summary_manager/index.html.twig', [
            'summary' => $this->get(SummaryManager::class)->getForAdherent($this->getUser()),
            'recent_activities' => [], // TODO $this->get(MembershipTracker::class)->getRecentActivitiesForAdherent($this->getUser()),
        ]);
    }

    /**
     * @Route("/experience/{id}", defaults={"id": ""}, name="app_summary_manager_handle_experience")
     * @Method("GET|POST")
     */
    public function handleExperienceAction(Request $request, ?JobExperience $experience)
    {
        $this->disableInProduction();

        $summaryManager = $this->get(SummaryManager::class);
        $summary = $summaryManager->getForAdherent($this->getUser());
        $form = $this->createForm(JobExperienceType::class, $experience, [
            'summary' => $summary,
        ]);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $summaryManager->handleExperience($summary, $experience);

            return $this->redirectToRoute('app_summary_manager_index');
        }

        return $this->render('');
    }
}

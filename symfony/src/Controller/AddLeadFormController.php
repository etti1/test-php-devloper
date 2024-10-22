<?php

namespace App\Controller;

use App\Form\LeadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AddLeadFormController extends AbstractController
{

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) // Внедряем HttpClientInterface
    {
        $this->client = $client;
    }


    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/add', name: 'lead_add')]
    public function addForm(Request $request): Response
    {
        $form = $this->createForm(LeadType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                $response = $this->client->request('POST', 'http://127.0.0.1:88/api/add/lead', [
                    'json' => $formData,
                ]);

                if ($response->getStatusCode() === 200) {
                    $this->addFlash('success', 'Лид успешно добавлен!');
                } else {
                    $this->addFlash('error', 'Ошибка при добавлении лида.');
                }
            } catch (\Exception $e) {
                $this->addFlash('error', 'Ошибка связи с API: ' . $e->getMessage());
            }


            return $this->redirectToRoute('lead_add');
        }

        return $this->render('add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
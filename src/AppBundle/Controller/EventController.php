<?php

namespace AppBundle\Controller;
use AppBundle\Addon\fileHelperTrait;
use AppBundle\Entity\User;
use AppBundle\Entity\UserEvent;
use AppBundle\Entity\UserProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use AppBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Event controller.
 *
 * @Route("event")
 */
class EventController extends Controller
{
    use fileHelperTrait;
    /**
     * Lists all event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     * var $userEvent - bind current user and event
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(UserEvent::class);
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($event);
        $applyForm = $this->createApplicateForm($event,$user);

        $userEvent = $repository
            ->loadKeys($user->getId(), $event->getId()
            );
        $userall = $repository->loadUsersByEvent($event->getId());

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
            'apply_form' => $applyForm->createView(),
            'userevent' => $userEvent,
            'userall' => $userall,
        ]);
    }

    /**
     * Print users list into file.
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/print", name="event_print_users")
     * @Method("GET")
     */
    public function printAction(Event $event)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(UserEvent::class);

        $eventusers = $repository->loadUsersByEvent($event->getId());
        $userall = $event->getUsers();

        $print = "<h2>";
        $print .= $event->getTitle()."<br>Список журналистов</h2>";
        $print .= "<table border='1' cellspacing='0' cellpadding='4'>";
        $print .= "<thead><tr><th>N</th><th>ФИО</th><th>СМИ</th><th>Дата рождения</th><th>Личный номер</th>";
        $print .= "<th>Паспортные данные</th><th>Адрес/Телефон</th><th>Заявка принята</th></tr></thead>";
        $n = 0;
        $status = ['на рассмотрении','принята','отклонена'];
        foreach ($userall as $ue) {
            $n += 1;
            $print .= "<tr>";
            $print .= "<td>".$n."</td>";
            $print .= "<td>".$ue->getUserprofile()->getFamily()."<br>".$ue->getUserprofile()->getName()." ".$ue->getUserprofile()->getSecondname()."</td>";
            $print .= "<td>".$ue->getSmi()."</td>";
            $print .= "<td>".$ue->getUserprofile()->getDataborn()."</td>";
            $print .= "<td>".$ue->getUserprofile()->getPrivatenum()."</td>";
            $print .= "<td>".
                      "Паспорт: ".$ue->getUserprofile()->getPassportnum()."<br>".
                      "Выдан: ".$ue->getUserprofile()->getIssuedata()."<br>".
                      $ue->getUserprofile()->getRuvd()."<br>".
                      "Срок действия: ".$ue->getUserprofile()->getEnddata()."<br>".
                      "Место рождения: ".$ue->getUserprofile()->getPlace().
                "</td>";
            $print .= "<td>".$ue->getUserprofile()->getAddress()."<br>Тел: ".$ue->getUserprofile()->getPhone()."</td>";
            foreach ($eventusers as $evuser) {
                if ($evuser->getUserId() == $ue->getId()){
                    $print .= "<td>".$status[$evuser->getStatus()]. "</td>";
                    break;
                }
            }
            $print .= "</tr>";
        }
        $print .= "</table>";

        $file_list = "list-".$event->getTitle();
        $this->createDoc($print, $file_list, 1);

        return $this->redirectToRoute('event_show', ['id' => $event->getId(), 'success' => 'yess!']);
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Application for event.
     *
     * @Route("/{id}", name="event_applicate")
     * @Method("POST")
     */
    public function applicateAction(Request $request, Event $event)
    {
        $user = $this->getUser();
        $form = $this->createApplicateForm($event, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->addEvent($event);
            $event->addUser($user);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('event_applicate', [
            'id' => $event->getId(),
        ]
        );
    }

    /**
     * Confirm User's Application for event.
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/{uid}", name="event_confirm")
     *
     */
    public function confirmAction(Request $request, Event $event)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userId = $request->get('uid');
        $status = $request->get('status');
        $confirm = $entityManager
            ->getRepository(UserEvent::class)
            ->loadKeys($userId, $event->getId()
            );

        if (!$confirm) {
            throw $this->createNotFoundException(
                'No user found for id '.$userId
            );
        }

        $confirm->setStatus($status);
        $entityManager->flush();

        return $this->redirectToRoute('event_show',[
            'id' => $event->getId(),
        ]);
    }

    // Form creation part -----------------------------------------------------------------

    /**
     * Creates a form to delete a event entity.
     * @param Event $event The event entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', [
                'id' => $event->getId()
            ]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form for participation request.
     * @param Event $event The event entity
     * @param User $user
     * @return \Symfony\Component\Form\Form The form
     */
    private function createApplicateForm(Event $event, User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_applicate', [
                'id' => $event->getId()
            ]))
            ->setMethod('POST')
            ->getForm()
            ;
    }




}

<?php

namespace SupportBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use SupportBundle\Entity\Ticket;
use SupportBundle\Form\TicketType;

class TicketController extends FOSRestController
{

    /**
     * Get all the tickets
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get all tickets",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @Get("/tickets")
     */
    public function getTicketsAction(){

        $tickets = $this->getDoctrine()->getRepository("SupportBundle:Ticket")
            ->findAll();

        return array('tickets' => $tickets);
    }

    /**
     * Get a ticket by ID
     * @param Ticket $ticket
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get a ticket",
     *  requirements={
     *      {
     *          "name"="ticket",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("ticket", class="SupportBundle:Ticket")
     * @Get("/ticket/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketAction(Ticket $ticket){

        return array('ticket' => $ticket);

    }

    /**
     * Get a ticket by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get a ticket",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket label"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @Get("/ticket/{label}")
     */
    public function getTicketByLabelAction($label){

        $ticket = $this->getDoctrine()->getRepository('SupportBundle:Ticket')->findOneBy(['label' => $label]);
        return array('ticket' => $ticket);
    }

    /**
     * Create a new Ticket
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Create a new Ticket",
     *  input="SupportBundle\Form\TicketType",
     *  output="SupportBundle\Entity\Ticket",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @Post("/ticket")
     */
    public function postTicketAction(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm(new TicketType(), $ticket);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return array("ticket" => $ticket);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Ticket
     * Put action
     * @var Request $request
     * @var Ticket $ticket
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Edit a Ticket",
     *  requirements={
     *      {
     *          "name"="ticket",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket id"
     *      }
     *  },
     *  input="SupportBundle\Form\TicketType",
     *  output="SupportBundle\Entity\Ticket",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @ParamConverter("ticket", class="SupportBundle:Ticket")
     * @Put("/ticket/{id}")
     */
    public function putTicketAction(Request $request, Ticket $ticket)
    {
        $form = $this->createForm(new TicketType(), $ticket);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket);
            $em->flush();

            return array("ticket" => $ticket);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Ticket
     * Delete action
     * @var Ticket $ticket
     * @return array
     *
     * @View()
     * @ParamConverter("ticket", class="SupportBundle:Ticket")
     * @Delete("/ticket/{id}")
     */
    public function deleteTicketAction(Ticket $ticket)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();

        return array("status" => "Deleted");
    }

}
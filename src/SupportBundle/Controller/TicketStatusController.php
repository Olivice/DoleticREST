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
use SupportBundle\Entity\TicketStatus;
use SupportBundle\Form\TicketStatusType;

class TicketStatusController extends FOSRestController
{

    /**
     * Get all the ticket_statuss
     * @return array
     *
     * @ApiDoc(
     *  section="TicketStatus",
     *  description="Get all ticket_statuss",
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
     * @Get("/ticket_statuss")
     */
    public function getTicketStatussAction(){

        $ticket_statuss = $this->getDoctrine()->getRepository("SupportBundle:TicketStatus")
            ->findAll();

        return array('ticket_statuss' => $ticket_statuss);
    }

    /**
     * Get a ticket_status by ID
     * @param TicketStatus $ticket_status
     * @return array
     *
     * @ApiDoc(
     *  section="TicketStatus",
     *  description="Get a ticket_status",
     *  requirements={
     *      {
     *          "name"="ticket_status",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket_status id"
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
     * @ParamConverter("ticket_status", class="SupportBundle:TicketStatus")
     * @Get("/ticket_status/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketStatusAction(TicketStatus $ticket_status){

        return array('ticket_status' => $ticket_status);

    }

    /**
     * Get a ticket_status by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="TicketStatus",
     *  description="Get a ticket_status",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket_status label"
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
     * @Get("/ticket_status/{label}")
     */
    public function getTicketStatusByLabelAction($label){

        $ticket_status = $this->getDoctrine()->getRepository('SupportBundle:TicketStatus')->findOneBy(['label' => $label]);
        return array('ticket_status' => $ticket_status);
    }

    /**
     * Create a new TicketStatus
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="TicketStatus",
     *  description="Create a new TicketStatus",
     *  input="SupportBundle\Form\TicketStatusType",
     *  output="SupportBundle\Entity\TicketStatus",
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
     * @Post("/ticket_status")
     */
    public function postTicketStatusAction(Request $request)
    {
        $ticket_status = new TicketStatus();
        $form = $this->createForm(new TicketStatusType(), $ticket_status);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket_status);
            $em->flush();

            return array("ticket_status" => $ticket_status);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a TicketStatus
     * Put action
     * @var Request $request
     * @var TicketStatus $ticket_status
     * @return array
     *
     * @ApiDoc(
     *  section="TicketStatus",
     *  description="Edit a TicketStatus",
     *  requirements={
     *      {
     *          "name"="ticket_status",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket_status id"
     *      }
     *  },
     *  input="SupportBundle\Form\TicketStatusType",
     *  output="SupportBundle\Entity\TicketStatus",
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
     * @ParamConverter("ticket_status", class="SupportBundle:TicketStatus")
     * @Put("/ticket_status/{id}")
     */
    public function putTicketStatusAction(Request $request, TicketStatus $ticket_status)
    {
        $form = $this->createForm(new TicketStatusType(), $ticket_status);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket_status);
            $em->flush();

            return array("ticket_status" => $ticket_status);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a TicketStatus
     * Delete action
     * @var TicketStatus $ticket_status
     * @return array
     *
     * @View()
     * @ParamConverter("ticket_status", class="SupportBundle:TicketStatus")
     * @Delete("/ticket_status/{id}")
     */
    public function deleteTicketStatusAction(TicketStatus $ticket_status)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket_status);
        $em->flush();

        return array("status" => "Deleted");
    }

}
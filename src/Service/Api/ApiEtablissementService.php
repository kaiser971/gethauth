<?php

namespace App\Service\Api;

use App\constants\MessageConstants;
use App\Repository\Api\ApiEtablissementRepository;
use Exception;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ApiEtablissementService
{
    private LoggerInterface $logger;
    private ApiEtablissementRepository $etablissementRepository;

    public function __construct(
        LoggerInterface            $logger,
        ApiEtablissementRepository $etablissementRepository,
    ) {
        $this->logger = $logger;
        $this->etablissementRepository = $etablissementRepository;
    }

    /**
     * Get FINESS Domain Information from the InfoService API for a specific Establishment (EPI).
     *
     * This method retrieves FINESS (Fichier des Etablissements Sanitaires et Sociaux) domain information
     * for a specific Establishment identified by its EPI (Établissement Public d'Insertion). It queries
     * the InfoService API to retrieve this information in XML format.
     *
     * @param string $ipe The EPI (Établissement Public d'Insertion) for which to retrieve FINESS domain information.
     *
     * @return SimpleXMLElement|null A SimpleXMLElement object containing the FINESS domain information in XML format
     *                            or null if there's an issue with the InfoService API communication.
     *
     * @throws Exception If there is a problem with the InfoService API communication, an exception is thrown,
     * @throws TransportExceptionInterface
     *                    and the issue is logged with details.
     */
    public function getFinessDomainXml(String $ipe): ?SimpleXMLElement
    {
        $finessDomainsXml = $this->etablissementRepository->getESInfoXml($ipe);
        if ($finessDomainsXml === null) {
            $this->logger->error(MessageConstants::PROBLEME_COMMUNICATION_INFOSERVICE_ETABLISSEMENT, ['ipe' => $ipe]);
            throw new Exception(MessageConstants::PROBLEME_COMMUNICATION_INFOSERVICE_ETABLISSEMENT);
        } elseif ($finessDomainsXml->exception) {
            $this->logger->error($finessDomainsXml->exception->libelle, ['ipe' => $ipe]);
            throw new Exception($finessDomainsXml->exception->libelle);
        }
        return $finessDomainsXml;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 17.03.17
 * Time: 12:26
 */

namespace ProjectBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class CertificateRenewCommand extends ContainerAwareCommand
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('proxy:certificate:renew')
            ->addArgument('domain', InputArgument::OPTIONAL, 'specify domain')
            ->setDescription('renew certificates');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $certificateManager = $this->getContainer()->get('project.certificate.manager');
        $hostManager = $this->getContainer()->get('project.manager.host');
        $domain = $input->getArgument('domain');
        if($domain) {
            $host = $hostManager->getHostByDomain($domain);
            if($host === null) {
                $output->writeln('cant find host');
            }
            $certificateManager->renewCertificate($host);
        } else {
            $certificateManager->renewCertificates();
        }
        $output->writeln('certificates renewed');
    }
}
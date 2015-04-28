<?php

/*
 * This file is part of Gush package.
 *
 * (c) 2013-2015 Luis Cordova <cordoval@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gush\Command\Branch;

use Gush\Command\BaseCommand;
use Gush\Feature\GitRepoFeature;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BranchPushCommand extends BaseCommand implements GitRepoFeature
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('branch:push')
            ->setDescription('Pushes and tracks the current local branch into user own fork')
            ->addArgument(
                'target_organization',
                InputArgument::OPTIONAL,
                'Organization of the branch you wan\'t to push to.'
            )
            ->addOption(
                'set-upstream',
                'u',
                InputOption::VALUE_NONE,
                'Set the target_organization as the default upstream'
            )
            ->setHelp(
                <<<EOF
The <info>%command.name%</info> command pushes the current local branch into your own fork:

    <info>$ gush %command.name%</info>

EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $branchName = $this->getHelper('git')->getActiveBranchName();
        $org = $input->getArgument('target_organization');

        if (null === $org) {
            $org = $this->getParameter($input, 'authentication')['username'];
        }

        $this->getHelper('git')->pushToRemote($org, $branchName, (bool) $input->getOption('set-upstream'));

        $this->getHelper('gush_style')->success(
            sprintf('Branch pushed to %s/%s', $org, $branchName)
        );

        return self::COMMAND_SUCCESS;
    }
}

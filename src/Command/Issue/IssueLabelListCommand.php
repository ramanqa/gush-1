<?php

/*
 * This file is part of Gush package.
 *
 * (c) Luis Cordova <cordoval@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gush\Command\Issue;

use Gush\Command\BaseCommand;
use Gush\Feature\IssueTrackerRepoFeature;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IssueLabelListCommand extends BaseCommand implements IssueTrackerRepoFeature
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('issue:label:list')
            ->setDescription('Lists the available issue\'s labels')
            ->setHelp(
                <<<EOF
The <info>%command.name%</info> command lists the issue's available labels for either the current or the given
organization and repository:

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
        $tracker = $this->getIssueTracker();
        $labels = $tracker->getLabels();

        $this->getHelper('gush_style')->listing($labels);

        return $labels;
    }
}

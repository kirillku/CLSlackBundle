<?php

namespace CL\Bundle\SlackBundle\Tests\DependencyInjection;

use CL\Bundle\SlackBundle\DependencyInjection\CLSlackExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\DependencyInjection\Reference;

class ExtensionTest extends AbstractExtensionTestCase
{
    public function testParameters()
    {
        $this->load([
            'api_token' => '1234',
        ]);

        $this->assertContainerBuilderHasParameter('cl_slack.api_token', '1234');
    }

    public function testServiceDefinitions()
    {
        $this->load([
            'api_token' => '1234',
        ]);

        $this->assertContainerBuilderHasService('cl_slack.api_client', 'CL\Slack\Transport\ApiClient');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('cl_slack.api_client', 0, '%cl_slack.api_token%');

        $this->assertContainerBuilderHasService('cl_slack.model_serializer', 'CL\Slack\Serializer\ModelSerializer');
        $this->assertContainerBuilderHasService('cl_slack.payload_factory', 'CL\Slack\Util\PayloadFactory');
        $this->assertContainerBuilderHasService('cl_slack.payload_serializer', 'CL\Slack\Serializer\PayloadSerializer');
        $this->assertContainerBuilderHasService('cl_slack.payload_response_serializer', 'CL\Slack\Serializer\PayloadResponseSerializer');
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [new CLSlackExtension()];
    }
}

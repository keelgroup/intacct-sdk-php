<?php

/**
 * Copyright 2017 Intacct Corporation.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Intacct;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

/**
 * @coversDefaultClass \Intacct\Credentials\SessionProvider
 */
class SessionProviderTest extends \PHPUnit\Framework\TestCase
{

    public function testFromLoginCredentials()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>sessionProvider</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>testuser</userid>
                  <companyid>testcompany</companyid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getSession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>fAkESesSiOnId..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $response = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $response,
        ]);
        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');
        $config->setCompanyId('testcompany');
        $config->setUserId('testuser');
        $config->setUserPassword('testpass');
        $config->setMockHandler($mock);
        
        $sessionCreds = SessionProvider::factory($config);
        
        $this->assertEquals('fAkESesSiOnId..', $sessionCreds->getSessionId());
        $this->assertEquals('https://unittest.intacct.com/ia/xml/xmlgw.phtml', $sessionCreds->getEndpointUrl());
    }

    public function testFromSessionCredentials()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<response>
      <control>
            <status>success</status>
            <senderid>testsenderid</senderid>
            <controlid>sessionProvider</controlid>
            <uniqueid>false</uniqueid>
            <dtdversion>3.0</dtdversion>
      </control>
      <operation>
            <authentication>
                  <status>success</status>
                  <userid>testuser</userid>
                  <companyid>testcompany</companyid>
                  <sessiontimestamp>2015-12-06T15:57:08-08:00</sessiontimestamp>
            </authentication>
            <result>
                  <status>success</status>
                  <function>getSession</function>
                  <controlid>testControlId</controlid>
                  <data>
                        <api>
                              <sessionid>fAkESesSiOnId..</sessionid>
                              <endpoint>https://unittest.intacct.com/ia/xml/xmlgw.phtml</endpoint>
                        </api>
                  </data>
            </result>
      </operation>
</response>
EOF;
        $headers = [
            'Content-Type' => 'text/xml; encoding="UTF-8"',
        ];
        $response = new Response(200, $headers, $xml);
        $mock = new MockHandler([
            $response,
        ]);
        $config = new ClientConfig();
        $config->setSenderId('testsenderid');
        $config->setSenderPassword('pass123!');
        $config->setSessionId('fAkESesSiOnId..');
        $config->setEndpointUrl('https://unittest.intacct.com/ia/xml/xmlgw.phtml');
        $config->setMockHandler($mock);

        $sessionCreds = SessionProvider::factory($config);

        $this->assertEquals('fAkESesSiOnId..', $sessionCreds->getSessionId());
        $this->assertEquals(
            'https://unittest.intacct.com/ia/xml/xmlgw.phtml',
            $sessionCreds->getEndpointUrl()
        );
    }
}
<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

namespace Intacct\Functions\AccountsPayable;


use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

abstract class AbstractBillLineTaxEntries extends AbstractFunction
{
    use CustomFieldsTrait;

    protected $taxId;
    protected $taxValue;

    /**
     * Get Tax Id
     *
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * Set Tax Id
     *
     * @param string $taxId
     */
    public function setTaxId($taxId): void
    {
        $this->taxId = $taxId;
    }

    /**
     * Get Tax Value
     *
     * @return float|string
     */
    public function getTaxValue()
    {
        return $this->taxValue;
    }

    /**
     * Set Tax Value
     *
     * @param float|string $taxValue
     */
    public function setTaxValue($taxValue): void
    {
        $this->taxValue = $taxValue;
    }

    abstract public function writeXml(XMLWriter &$xml);

}
<?php

/*
 * Copyright (C) 2023 Deciso B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace OPNsense\Core\Api;

use OPNsense\Base\ApiMutableModelControllerBase;

class DashboardController extends ApiMutableModelControllerBase
{
    protected static $internalModelClass = '\OPNsense\Core\Dashboard';
    protected static $internalModelName = 'dashboard';

    public function getWidgetsAction()
    {
        $this->sessionClose();
        /* XXX: model checks etc. */

        $widgets = array_filter(array_map(
            function($element) {
                return basename($element);
            }, glob('/usr/local/opnsense/www/js/widgets/*.js')), 
            function($element) {
                if (strpos($element, '.js') !== false && strpos($element, 'Base') === false) {
                    return true;
                }

                return false;
            }
        );

        error_log(print_r($widgets, true));

        $conf = $this->getAction();
        error_log(print_r($conf, true));


        return json_encode(array_values($widgets));
    }

    // front-end can do set call
    // public function saveWidgetsAction()
    // {
    //     $result = parent::setAction();
    //     if ($result['result'] != 'failed') {
            
    //     }
    //     return json_encode($result);
    // }
}
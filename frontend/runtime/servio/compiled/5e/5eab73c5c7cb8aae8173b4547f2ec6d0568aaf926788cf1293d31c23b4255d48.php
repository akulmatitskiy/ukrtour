<?php

/* _widgets/SearchForm.twig */
class __TwigTemplate_15c48b7ce8602f17ed7154efcede3426fd42953326975bfcd7b418f73c8159e1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- SERVIO BOOKING SEARCH FORM-->
<div class=\"servio-booking-title hide-on-med-only\">
    ";
        // line 3
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "FormTitle")), "html", null, true);
        echo "
</div>
<div class=\"servio-search-form\">

    <form id=\"servioSearchForm\" name=\"servioSearchForm\" method=\"post\" 
          action=\"";
        // line 8
        if (((isset($context["lang"]) ? $context["lang"] : null) != "uk")) {
            echo "/";
            echo twig_escape_filter($this->env, (isset($context["lang"]) ? $context["lang"] : null), "html", null, true);
        }
        echo "/hotels-search\" 
          data-loader=\"";
        // line 9
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "loader")), "html", null, true);
        echo "\">
        <!-- LIST OF HOTELS -->
        <div class=\"servio-search-input\"";
        // line 11
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "booking", array()), "visible", array()), "hotelId", array()) == 0)) {
            echo " style=\"display: none\"";
        }
        echo ">
            <div id=\"booking-hotel\" class=\"card\">
                <div class=\"input-field col s12\">
                    <select id=\"servioHotelId\" name=\"search[hotelId]\" class=\"validate\"
                            title=\"";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "SelectHotel")), "html", null, true);
        echo "\" required>
                        <option value=\"\" disabled selected>";
        // line 16
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "Hotel")), "html", null, true);
        echo "</option>
                        ";
        // line 17
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["cities"]) ? $context["cities"] : null));
        foreach ($context['_seq'] as $context["cityId"] => $context["city"]) {
            // line 18
            echo "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["hotels"]) ? $context["hotels"] : null), $context["cityId"], array(), "array"));
            foreach ($context['_seq'] as $context["hotelId"] => $context["hotel"]) {
                // line 19
                echo "                                <option value=\"";
                echo twig_escape_filter($this->env, $context["hotelId"], "html", null, true);
                echo "\" ";
                if (($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "hotelId", array()) == $context["hotelId"])) {
                    echo "selected";
                }
                echo "><strong>";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["city"], "translates", array()), (isset($context["lang"]) ? $context["lang"] : null), array(), "array"), "name", array()), "html", null, true);
                echo ":</strong> ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["hotel"], "translates", array()), (isset($context["lang"]) ? $context["lang"] : null), array(), "array"), "name", array()), "html", null, true);
                echo "</option>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['hotelId'], $context['hotel'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 21
            echo "                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['cityId'], $context['city'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "                    </select>
                </div>
            </div>
        </div>
        <div id=\"find-hotel\">
            <a href=\"/#map\" class=\"waves-effect waves-light btn-flat hide-on-small-only\"
               title=\"";
        // line 28
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "FindHotelOnMap")), "html", null, true);
        echo "\">
                <i class=\"material-icons left\">place</i>
                <span class=\"\">";
        // line 30
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "FindHotelOnMap")), "html", null, true);
        echo "</span>
            </a>
        </div>
        <div id=\"booking-dates\">
            <!-- DATE AND TIME OF ARRIVAL -->
            <div class=\"card booking-date\">
                <label>";
        // line 36
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "ArrivalDate")), "html", null, true);
        echo "</label>
                <input id=\"servioDateArrival\" type=\"text\" name=\"search[arrival]\" 
                       value=\"";
        // line 38
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "arrival", array()), "d.m.Y H:i"), "html", null, true);
        echo "\"
                       class=\"input-field\">
            </div>

            <!-- DATE AND TIME OF DEPARTURE -->
            <div class=\"card booking-date\">
                <label>";
        // line 44
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "DepartureDate")), "html", null, true);
        echo "</label>
                <input id=\"servioDateDeparture\" type=\"text\" name=\"search[departure]\" 
                       value=\"";
        // line 46
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "departure", array()), "d.m.Y H:i"), "html", null, true);
        echo "\"
                       class=\"input-field\">
            </div>
        </div>
        <!-- HOW MANY ROOMS TO BOOK -->
        <div id=\"rooms-num\" class=\"card col servio-search-input input-field hide\">
            <select id=\"servioSearchRoomsCount\" name=\"roomsCount\" type=\"number\">
                ";
        // line 53
        $context["rooms_count"] = twig_length_filter($this->env, (($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array()), array(0 => array()))) : (array(0 => array()))));
        // line 54
        echo "                ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(1, 5));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            echo "<option value=\"";
            echo twig_escape_filter($this->env, $context["i"], "html", null, true);
            echo "\"";
            if (($context["i"] == (isset($context["rooms_count"]) ? $context["rooms_count"] : null))) {
                echo " selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $context["i"], "html", null, true);
            echo "</option>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "            </select>
            <label for=\"servioSearchRoomsCount\">";
        // line 56
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "RoomsCount")), "html", null, true);
        echo "</label>
        </div>

        ";
        // line 59
        $context["age"] = $this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "booking", array(), "array"), "childAge", array());
        // line 60
        echo "
        <!-- ROOMS SETUP -->
        ";
        // line 62
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 4));
        foreach ($context['_seq'] as $context["_key"] => $context["r"]) {
            // line 63
            echo "            ";
            $context["hidden"] = ($context["r"] >= (isset($context["rooms_count"]) ? $context["rooms_count"] : null));
            // line 64
            echo "
            <!-- ROOM SETUP PANEL -->
            <fieldset class=\"servio-search-room\" id=\"searchRoom";
            // line 66
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "\"";
            if ((isset($context["hidden"]) ? $context["hidden"] : null)) {
                echo " 
                      style=\"display: none\" disabled";
            }
            // line 67
            echo ">

                <!-- ROOM PANEL TITLE -->
                ";
            // line 70
            if (($context["r"] > 0)) {
                // line 71
                echo "                    <div class=\"servio-search-input servio-search-input-title\">
                        ";
                // line 72
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "Room", array(0 => ($context["r"] + 1)))), "html", null, true);
                echo "
                    </div>
                ";
            }
            // line 75
            echo "
                <div id=\"guests\" layout=\"row\" layout-align=\"space-between center\">
                    <!-- ADULT GUESTS COUNT -->
                    <div id=\"guests-adult\" class=\"card booking-guests\">
                        <label>";
            // line 79
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "Adults")), "html", null, true);
            echo "</label>
                        ";
            // line 80
            $context["selected"] = (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", false, true), $context["r"], array(), "array", false, true), "adults", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", false, true), $context["r"], array(), "array", false, true), "adults", array()), 1)) : (1));
            // line 81
            echo "                        <select id=\"adults";
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "\" name=\"search[rooms][";
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "][adults]\">
                            ";
            // line 82
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(range(1, 4));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 83
                echo "                                <option value=\"";
                echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                echo "\"";
                if (($context["i"] == (isset($context["selected"]) ? $context["selected"] : null))) {
                    echo " selected";
                }
                echo ">";
                echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                echo "</option>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 85
            echo "                        </select>
                    </div>

                    ";
            // line 88
            $context["children"] = twig_length_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", false, true), $context["r"], array(), "array", false, true), "childrenAges", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", false, true), $context["r"], array(), "array", false, true), "childrenAges", array()), array())) : (array())));
            // line 89
            echo "
                    <!-- CHILDREN -->
                    <div class=\"card booking-guests\">
                        <label for=\"servioChildren";
            // line 92
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "Children")), "html", null, true);
            echo "</label>
                        <select id=\"servioChildren";
            // line 93
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "\" 
                                name=\"search[rooms][";
            // line 94
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "][children]\" 
                                class=\"input-field\">
                            ";
            // line 96
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(range(0, 3));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 97
                echo "                                <option value=\"";
                echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                echo "\"";
                if (($context["i"] == (isset($context["children"]) ? $context["children"] : null))) {
                    echo " selected";
                }
                echo ">";
                echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                echo "</option>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 99
            echo "                        </select>
                    </div>
                </div>

                <!-- CHILDREN AGES -->
                <fieldset id=\"servioChildrenAges";
            // line 104
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "-0\" class=\"servio-search-input\"";
            if (((isset($context["children"]) ? $context["children"] : null) == 0)) {
                echo " style=\"display: none\"";
            }
            echo ">
                    <label style=\"padding-left: 10px\">";
            // line 106
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "ChildrenAges")), "html", null, true);
            // line 107
            echo "</label>
                    <div class=\"servio-search-input-group input-field\">";
            // line 109
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(range(1, 3));
            foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
                // line 110
                $context["agehidden"] = ($context["c"] >= (isset($context["children"]) ? $context["children"] : null));
                // line 111
                echo "                        ";
                $context["ageselected"] = (($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", false, true), $context["r"], array(), "array", false, true), "childrenAges", array(), "any", false, true), ($context["c"] - 1), array(), "array", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array(), "any", false, true), $context["r"], array(), "array", false, true), "childrenAges", array(), "any", false, true), ($context["c"] - 1), array(), "array"), 0)) : (0));
                // line 112
                echo "                        <select id=\"servioChildrenAges";
                echo twig_escape_filter($this->env, $context["r"], "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, $context["c"], "html", null, true);
                echo "\" name=\"search[rooms][";
                echo twig_escape_filter($this->env, $context["r"], "html", null, true);
                echo "][childrenAges][";
                echo twig_escape_filter($this->env, ($context["c"] - 1), "html", null, true);
                echo "]\" class=\"servio-search-input-age input-age";
                echo twig_escape_filter($this->env, $context["r"], "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, $context["c"], "html", null, true);
                echo "\"";
                if ((isset($context["agehidden"]) ? $context["agehidden"] : null)) {
                    echo " style=\"visibility: hidden\"";
                }
                echo ">
                            ";
                // line 113
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(0, (isset($context["age"]) ? $context["age"] : null)));
                foreach ($context['_seq'] as $context["_key"] => $context["a"]) {
                    echo "<option value=\"";
                    echo twig_escape_filter($this->env, $context["a"], "html", null, true);
                    echo "\"";
                    if (($context["a"] == (isset($context["ageselected"]) ? $context["ageselected"] : null))) {
                        echo " selected";
                    }
                    echo ">";
                    echo twig_escape_filter($this->env, $context["a"], "html", null, true);
                    echo "</option>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['a'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 114
                echo "                        </select>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 116
            echo "</div>
                </fieldset>

                <!-- USE ADDITIONAL BEDS -->
                <div id=\"extraBeds\">
                    <input type=\"checkbox\" id=\"extraBeds";
            // line 121
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "\" name=\"search[rooms][";
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "][isExtraBedUsed]\" 
                           value=\"1\"";
            // line 122
            if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "rooms", array()), $context["r"], array(), "array"), "isExtraBedUsed", array())) {
                echo " checked";
            }
            echo ">
                    <label for=\"extraBeds";
            // line 123
            echo twig_escape_filter($this->env, $context["r"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "ExtraBeds")), "html", null, true);
            echo "</label>
                </div>

            </fieldset>

        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['r'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 129
        echo "
        <div class=\"clear\"></div>

        <!-- COMPANY PASSWORD OR PROMOTIONAL CODE -->
        <div class=\"servio-search-input\" id=\"companyCode\"";
        // line 133
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "booking", array()), "visible", array()), "companyCode", array()) == 0)) {
            echo " style=\"display: none\"";
        }
        echo ">
            <label for=\"servioCompanyCode\">";
        // line 134
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "CCode")), "html", null, true);
        echo "</label>
            <input type=\"text\" id=\"servioCompanyCode\" maxlength=\"30\" name=\"search[companyCode]\" value=\"";
        // line 135
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "companyCode", array()), "html", null, true);
        echo "\" title=\"Укажите код компании или акции\" />
        </div>

        <!-- RETURNING CUSTOMER\"S CARD NUMBER -->
        <div class=\"servio-search-input\" id=\"loyaltyCard\"";
        // line 139
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "booking", array()), "visible", array()), "loyaltyCard", array()) == 0)) {
            echo " style=\"display: none\"";
        }
        echo ">
            <label for=\"servioLoyaltyCard\">";
        // line 140
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "CLoyaltyCard")), "html", null, true);
        echo "</label>
            <input type=\"text\" id=\"servioLoyaltyCard\" maxlength=\"30\" name=\"search[loyaltyCard]\" value=\"";
        // line 141
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "loyaltyCard", array()), "html", null, true);
        echo "\" />
        </div>

        <!-- APPLY TOURIST TAX -->
        <div id=\"touristTax\"";
        // line 145
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : null), "booking", array()), "visible", array()), "touristTax", array()) == 0)) {
            echo " style=\"display: none\"";
        }
        echo ">
            <input type=\"checkbox\" id=\"servioTouristTax\" name=\"search[isTouristTax]\" value=\"1\"";
        // line 146
        if ($this->getAttribute((isset($context["searchRequest"]) ? $context["searchRequest"] : null), "isTouristTax", array())) {
            echo " checked";
        }
        echo ">
            <label for=\"servioTouristTax\" >";
        // line 147
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "isTouristTax")), "html", null, true);
        echo "</label>
        </div>

        <!-- SUBMIT BUTTON -->
        <button id=\"servio-search-button\" class=\"button-booking waves-effect btn\"
                type=\"submit\">
            ";
        // line 153
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('_')->getCallable(), array("search", "SearchRequest")), "html", null, true);
        echo "
        </button>

    </form>

</div>

<script>
    // SHOW/HIDE ROOM PANELS
    (function servioRoomsCount() {
        var rooms = document.getElementById(\"servioSearchForm\").getElementsByClassName(\"servio-search-room\");
        var count = document.getElementById(\"servioSearchRoomsCount\").value;
        if (!rooms.count_ || rooms.count_ != count) {
            rooms.count_ = count;
            for (var room, index = 0; index < rooms.length && (room = rooms[index]); index++)
                room.style.display = (room.disabled = index >= count) ? \"none\" : \"block\";
        }
        setTimeout(servioRoomsCount, 500); // schedule next check in .5 sec
    })();

    // SHOW/HIDE CHILDREN AGES INPUTS
    (function servioChildrenCount() {
        var rooms = document.getElementById(\"servioSearchForm\").getElementsByClassName(\"servio-search-room\");
        for (var room, index = 0; index < rooms.length && (room = rooms[index]); index++) {
            var children = parseInt(document.getElementById(\"servioChildren\" + index).value);
            var fieldset = document.getElementById(\"servioChildrenAges\" + index + \"-0\");
            if (!children) {
                fieldset.style.display =  \"none\";
            } else {
                if (fieldset.disabled) {
                    fieldset.style.display =  \"none\";
                } else {
                    fieldset.style.display =  \"block\";
                }
                    //fieldset.style.display = (fieldset.disabled = false) ? \"none\" : \"block\";
                for (var child = 1; child <= 3; child++) {
                    var input = \$(\".input-age\" + index + \"-\" + child);
                    if(child > children) {
                        input.hide();
                    } else {
                        input.show();
                    }
                }
            }
        }
        setTimeout(servioChildrenCount, 200); // schedule next check in .5 sec
    })();
</script>
";
    }

    public function getTemplateName()
    {
        return "_widgets/SearchForm.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  461 => 153,  452 => 147,  446 => 146,  440 => 145,  433 => 141,  429 => 140,  423 => 139,  416 => 135,  412 => 134,  406 => 133,  400 => 129,  386 => 123,  380 => 122,  374 => 121,  367 => 116,  361 => 114,  344 => 113,  325 => 112,  322 => 111,  320 => 110,  316 => 109,  313 => 107,  311 => 106,  303 => 104,  296 => 99,  281 => 97,  277 => 96,  272 => 94,  268 => 93,  262 => 92,  257 => 89,  255 => 88,  250 => 85,  235 => 83,  231 => 82,  224 => 81,  222 => 80,  218 => 79,  212 => 75,  206 => 72,  203 => 71,  201 => 70,  196 => 67,  189 => 66,  185 => 64,  182 => 63,  178 => 62,  174 => 60,  172 => 59,  166 => 56,  163 => 55,  145 => 54,  143 => 53,  133 => 46,  128 => 44,  119 => 38,  114 => 36,  105 => 30,  100 => 28,  92 => 22,  86 => 21,  69 => 19,  64 => 18,  60 => 17,  56 => 16,  52 => 15,  43 => 11,  38 => 9,  31 => 8,  23 => 3,  19 => 1,);
    }

    public function getSource()
    {
        return "<!-- SERVIO BOOKING SEARCH FORM-->
<div class=\"servio-booking-title hide-on-med-only\">
    {{ _(\"search\", \"FormTitle\") }}
</div>
<div class=\"servio-search-form\">

    <form id=\"servioSearchForm\" name=\"servioSearchForm\" method=\"post\" 
          action=\"{% if lang != 'uk' %}/{{lang}}{% endif %}/hotels-search\" 
          data-loader=\"{{ _(\"search\", \"loader\") }}\">
        <!-- LIST OF HOTELS -->
        <div class=\"servio-search-input\"{% if config.booking.visible.hotelId == 0 %} style=\"display: none\"{% endif %}>
            <div id=\"booking-hotel\" class=\"card\">
                <div class=\"input-field col s12\">
                    <select id=\"servioHotelId\" name=\"search[hotelId]\" class=\"validate\"
                            title=\"{{ _(\"search\", \"SelectHotel\") }}\" required>
                        <option value=\"\" disabled selected>{{ _(\"search\", \"Hotel\") }}</option>
                        {% for cityId, city in cities %}
                            {% for hotelId, hotel in hotels[cityId] %}
                                <option value=\"{{ hotelId }}\" {% if searchRequest.hotelId == hotelId %}selected{% endif %}><strong>{{ city.translates[lang].name }}:</strong> {{ hotel.translates[lang].name }}</option>
                            {% endfor %}
                        {% endfor %}
                    </select>
                </div>
            </div>
        </div>
        <div id=\"find-hotel\">
            <a href=\"/#map\" class=\"waves-effect waves-light btn-flat hide-on-small-only\"
               title=\"{{ _(\"search\", \"FindHotelOnMap\") }}\">
                <i class=\"material-icons left\">place</i>
                <span class=\"\">{{ _(\"search\", \"FindHotelOnMap\") }}</span>
            </a>
        </div>
        <div id=\"booking-dates\">
            <!-- DATE AND TIME OF ARRIVAL -->
            <div class=\"card booking-date\">
                <label>{{ _(\"search\", \"ArrivalDate\") }}</label>
                <input id=\"servioDateArrival\" type=\"text\" name=\"search[arrival]\" 
                       value=\"{{ searchRequest.arrival | date(\"d.m.Y H:i\") }}\"
                       class=\"input-field\">
            </div>

            <!-- DATE AND TIME OF DEPARTURE -->
            <div class=\"card booking-date\">
                <label>{{ _(\"search\", \"DepartureDate\") }}</label>
                <input id=\"servioDateDeparture\" type=\"text\" name=\"search[departure]\" 
                       value=\"{{ searchRequest.departure | date(\"d.m.Y H:i\") }}\"
                       class=\"input-field\">
            </div>
        </div>
        <!-- HOW MANY ROOMS TO BOOK -->
        <div id=\"rooms-num\" class=\"card col servio-search-input input-field hide\">
            <select id=\"servioSearchRoomsCount\" name=\"roomsCount\" type=\"number\">
                {% set rooms_count = searchRequest.rooms | default([{}]) | length %}
                {% for i in 1..5 %}<option value=\"{{ i }}\"{% if i == rooms_count %} selected{% endif %}>{{ i }}</option>{% endfor %}
            </select>
            <label for=\"servioSearchRoomsCount\">{{ _(\"search\", \"RoomsCount\") }}</label>
        </div>

        {% set age = config[\"booking\"].childAge %}

        <!-- ROOMS SETUP -->
        {% for r in 0..4 %}
            {% set hidden = r >= rooms_count %}

            <!-- ROOM SETUP PANEL -->
            <fieldset class=\"servio-search-room\" id=\"searchRoom{{ r }}\"{% if hidden %} 
                      style=\"display: none\" disabled{% endif %}>

                <!-- ROOM PANEL TITLE -->
                {% if r > 0 %}
                    <div class=\"servio-search-input servio-search-input-title\">
                        {{ _(\"search\", \"Room\", [r + 1]) }}
                    </div>
                {% endif %}

                <div id=\"guests\" layout=\"row\" layout-align=\"space-between center\">
                    <!-- ADULT GUESTS COUNT -->
                    <div id=\"guests-adult\" class=\"card booking-guests\">
                        <label>{{ _(\"search\", \"Adults\") }}</label>
                        {% set selected = searchRequest.rooms[r].adults | default(1) %}
                        <select id=\"adults{{ r }}\" name=\"search[rooms][{{ r }}][adults]\">
                            {% for i in 1..4 %}
                                <option value=\"{{ i }}\"{% if i == selected %} selected{% endif %}>{{ i }}</option>
                            {% endfor %}
                        </select>
                    </div>

                    {% set children = searchRequest.rooms[r].childrenAges | default([]) | length %}

                    <!-- CHILDREN -->
                    <div class=\"card booking-guests\">
                        <label for=\"servioChildren{{ r }}\">{{ _(\"search\", \"Children\") }}</label>
                        <select id=\"servioChildren{{ r }}\" 
                                name=\"search[rooms][{{ r }}][children]\" 
                                class=\"input-field\">
                            {% for i in 0..3 %}
                                <option value=\"{{ i }}\"{% if i == children %} selected{% endif %}>{{ i }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>

                <!-- CHILDREN AGES -->
                <fieldset id=\"servioChildrenAges{{ r }}-0\" class=\"servio-search-input\"{% if children == 0 %} style=\"display: none\"{% endif %}>
                    <label style=\"padding-left: 10px\">
                        {{- _(\"search\", \"ChildrenAges\") -}}
                    </label>
                    <div class=\"servio-search-input-group input-field\">
                        {%- for c in 1..3 -%}
                        {% set agehidden = c >= children %}
                        {% set ageselected = searchRequest.rooms[r].childrenAges[c - 1] | default(0) %}
                        <select id=\"servioChildrenAges{{ r }}-{{ c }}\" name=\"search[rooms][{{ r }}][childrenAges][{{ c - 1 }}]\" class=\"servio-search-input-age input-age{{ r }}-{{ c }}\"{% if agehidden %} style=\"visibility: hidden\"{% endif %}>
                            {% for a in 0..age %}<option value=\"{{ a }}\"{% if a == ageselected %} selected{% endif %}>{{ a }}</option>{% endfor %}
                        </select>
                        {%- endfor -%}
                    </div>
                </fieldset>

                <!-- USE ADDITIONAL BEDS -->
                <div id=\"extraBeds\">
                    <input type=\"checkbox\" id=\"extraBeds{{ r }}\" name=\"search[rooms][{{ r }}][isExtraBedUsed]\" 
                           value=\"1\"{% if searchRequest.rooms[r].isExtraBedUsed %} checked{% endif %}>
                    <label for=\"extraBeds{{ r }}\">{{ _(\"search\", \"ExtraBeds\") }}</label>
                </div>

            </fieldset>

        {% endfor %}

        <div class=\"clear\"></div>

        <!-- COMPANY PASSWORD OR PROMOTIONAL CODE -->
        <div class=\"servio-search-input\" id=\"companyCode\"{% if config.booking.visible.companyCode == 0 %} style=\"display: none\"{% endif %}>
            <label for=\"servioCompanyCode\">{{ _(\"search\", \"CCode\") }}</label>
            <input type=\"text\" id=\"servioCompanyCode\" maxlength=\"30\" name=\"search[companyCode]\" value=\"{{ searchRequest.companyCode }}\" title=\"Укажите код компании или акции\" />
        </div>

        <!-- RETURNING CUSTOMER\"S CARD NUMBER -->
        <div class=\"servio-search-input\" id=\"loyaltyCard\"{% if config.booking.visible.loyaltyCard == 0 %} style=\"display: none\"{% endif %}>
            <label for=\"servioLoyaltyCard\">{{ _(\"search\", \"CLoyaltyCard\") }}</label>
            <input type=\"text\" id=\"servioLoyaltyCard\" maxlength=\"30\" name=\"search[loyaltyCard]\" value=\"{{ searchRequest.loyaltyCard }}\" />
        </div>

        <!-- APPLY TOURIST TAX -->
        <div id=\"touristTax\"{% if config.booking.visible.touristTax == 0 %} style=\"display: none\"{% endif %}>
            <input type=\"checkbox\" id=\"servioTouristTax\" name=\"search[isTouristTax]\" value=\"1\"{% if searchRequest.isTouristTax %} checked{% endif %}>
            <label for=\"servioTouristTax\" >{{ _(\"search\", \"isTouristTax\") }}</label>
        </div>

        <!-- SUBMIT BUTTON -->
        <button id=\"servio-search-button\" class=\"button-booking waves-effect btn\"
                type=\"submit\">
            {{ _(\"search\", \"SearchRequest\") }}
        </button>

    </form>

</div>

<script>
    // SHOW/HIDE ROOM PANELS
    (function servioRoomsCount() {
        var rooms = document.getElementById(\"servioSearchForm\").getElementsByClassName(\"servio-search-room\");
        var count = document.getElementById(\"servioSearchRoomsCount\").value;
        if (!rooms.count_ || rooms.count_ != count) {
            rooms.count_ = count;
            for (var room, index = 0; index < rooms.length && (room = rooms[index]); index++)
                room.style.display = (room.disabled = index >= count) ? \"none\" : \"block\";
        }
        setTimeout(servioRoomsCount, 500); // schedule next check in .5 sec
    })();

    // SHOW/HIDE CHILDREN AGES INPUTS
    (function servioChildrenCount() {
        var rooms = document.getElementById(\"servioSearchForm\").getElementsByClassName(\"servio-search-room\");
        for (var room, index = 0; index < rooms.length && (room = rooms[index]); index++) {
            var children = parseInt(document.getElementById(\"servioChildren\" + index).value);
            var fieldset = document.getElementById(\"servioChildrenAges\" + index + \"-0\");
            if (!children) {
                fieldset.style.display =  \"none\";
            } else {
                if (fieldset.disabled) {
                    fieldset.style.display =  \"none\";
                } else {
                    fieldset.style.display =  \"block\";
                }
                    //fieldset.style.display = (fieldset.disabled = false) ? \"none\" : \"block\";
                for (var child = 1; child <= 3; child++) {
                    var input = \$(\".input-age\" + index + \"-\" + child);
                    if(child > children) {
                        input.hide();
                    } else {
                        input.show();
                    }
                }
            }
        }
        setTimeout(servioChildrenCount, 200); // schedule next check in .5 sec
    })();
</script>
";
    }
}

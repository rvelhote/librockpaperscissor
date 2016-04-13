<?php
/*
 * The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Balwan\RockPaperScissor\Rules;

/**
 * Class RulesTest
 * @package Balwan\RockPaperScissor\Rules
 */
class RulesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Make sure that the weapons array from the ruleset matches the expected data.
     */
    public function testWeapons() {
        $rules = new Rules();

        $rules->addRule(new Rule("Scissors", "Paper", "Cuts"));
        $rules->addRule(new Rule("Paper", "Rock", "Covers"));
        $rules->addRule(new Rule("Rock", "Lizard", "Crushes"));
        $rules->addRule(new Rule("Lizard", "Spock", "Poisons"));
        $rules->addRule(new Rule("Spock", "Scissors", "Smashes"));
        $rules->addRule(new Rule("Scissors", "Lizard", "Decapitates"));
        $rules->addRule(new Rule("Lizard", "Paper", "Eats"));
        $rules->addRule(new Rule("Paper", "Spock", "Disproves"));
        $rules->addRule(new Rule("Spock", "Rock", "Vaporizes"));
        $rules->addRule(new Rule("Rock", "Scissors", "Crushes"));
        $rules->addRule(new Rule("Spock", "Rock", "Vaporizes"));

        $expected = [
            "Scissors",
            "Paper",
            "Rock",
            "Lizard",
            "Spock",
        ];

        $this->assertCount(5, $rules->getWeapons(), "The number of weapons should be 5");
        $this->assertEquals($expected, $rules->getWeapons(), "Weapons array should contain: ".implode(",", $expected));
    }

    /**
     * Make sure that a rule that was added and a rule that is later obtained is the same.
     * Also input data with different cases and empty padding and a rule that does not exist (should return null).
     */
    public function testAddRule() {
        $ruleToInsert = new Rule("Scissors", "Paper", "Cuts");

        $rules = new Rules();
        $rules->addRule($ruleToInsert);

        // Correct casing
        $ruleToObtain = $rules->getRule("Scissors", "Paper");
        $this->assertEquals($ruleToObtain, $ruleToInsert, "[1] The inserted and obtained rule are not the same");

        // Random casing
        $ruleToObtain = $rules->getRule("ScIsSoRs", "PaPeR");
        $this->assertEquals($ruleToObtain, $ruleToInsert, "[2] The inserted and obtained rule are not the same");

        // Random casing and empty padding
        $ruleToObtain = $rules->getRule("       ScIsSoRs      ", "      PaPeR        ");
        $this->assertEquals($ruleToObtain, $ruleToInsert, "[3] The inserted and obtained rule are not the same");

        // Non-existent rule
        $ruleToObtain = $rules->getRule("Rock", "Spock");
        $this->assertNull($ruleToObtain, "Rule should be null because it does not exist");
    }
}

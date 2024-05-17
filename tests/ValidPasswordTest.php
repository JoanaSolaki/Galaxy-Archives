<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Regex;

class ValidPasswordTest extends TestCase
{
    public function testValidPassword()
    {
        $validator = Validation::createValidator();
        $password = 'MyStrongPassword123';
        $constraint = new Regex([
            'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/',
            'message' => 'Le mot de passe doit contenir au moins une lettre
            majuscule, une lettre minuscule, un chiffre et avoir une longueur minimale de 8
            caractères.',
        ]);
        $violations = $validator->validate($password, $constraint);
        $this->assertCount(0, $violations);
    }

    public function testInvalidPassword()
    {
        $validator = Validation::createValidator();
        $password = 'weak';
        $constraint = new Regex([
            'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/',
            'message' => 'Le mot de passe doit contenir au moins une lettre
            majuscule, une lettre minuscule, un chiffre et avoir une longueur minimale de 8
            caractères.',
        ]);
        $violations = $validator->validate($password, $constraint);
        $this->assertCount(1, $violations);
    }
}

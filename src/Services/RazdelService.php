<?php


namespace App\Services;


use App\Repository\ResurRazdelsRepos;
use App\Repository\RsurElementsRepository;

class RazdelService
{
    /**
     * @var ResurRazdelsRepos
     */
    private $razdelsRepos;
    /**
     * @var RsurElementsRepository
     */
    private $elementsRepository;

    public function __construct(ResurRazdelsRepos $razdelsRepos, RsurElementsRepository $elementsRepository)
    {
        $this->razdelsRepos = $razdelsRepos;
        $this->elementsRepository = $elementsRepository;
    }

    public function GetGrade(int $razdelId, int $participId): int
    {
        return $this->calculateGrade($this->elementsRepository->getElementsByRazdelWithGrades($razdelId, $participId));
    }

    private function calculateGrade(array $elements): int
    {
        $all = count($elements);
        $passed = 0;
        foreach ($elements as $element) {
            if ((int)$element['grade'] === 5) {
                $passed++;
            }
        }
        $proc = round($passed / $all * 100);
        if ($proc >= 70) {
            return 5;
        }
        return 2;
    }
}
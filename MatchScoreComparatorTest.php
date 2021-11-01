<?php
interface MatchScoreInterface
{
    public function getNumericValue(): int;
}

class MatchScore implements MatchScoreInterface
{
    private int $numericValue;

    function __construct(int $numericValue = NULL) {
        if(is_null($numericValue))
            $this->numericValue = rand(-100, 100);
        else
            $this->numericValue = $numericValue;
    }

    public function getNumericValue(): int {
        return $this->numericValue;
    }
}

class MatchScoreComparator
{
    public function compare(MatchScoreInterface $score1, MatchScoreInterface $score2): int
    {
        return $score1->getNumericValue() <=> $score2->getNumericValue();
    }

    public function equals(MatchScoreInterface $score1, MatchScoreInterface $score2): bool
    {
        return $score1->getNumericValue() === $score2->getNumericValue();
    }
}

class MatchScoreComparatorTest extends \PHPUnit\Framework\TestCase
{
    public function testCompare() {
        $matchScoreComparator = new MatchScoreComparator();
        
        $matchScoreMedium = new MatchScore();
        $matchScoreMinor = new MatchScore($matchScoreMedium->getNumericValue() - 1);
        $matchScoreMajor = new MatchScore($matchScoreMedium->getNumericValue() + 1);
        
        $resultEqual = $matchScoreComparator->compare($matchScoreMedium, $matchScoreMedium);
        $this->assertEquals($resultEqual, 0);

        $resultLessThan = $matchScoreComparator->compare($matchScoreMedium, $matchScoreMajor);
        $this->assertEquals($resultLessThan, -1);

        $resultMoreThan = $matchScoreComparator->compare($matchScoreMedium, $matchScoreMinor);
        $this->assertEquals($resultMoreThan, 1);
    }

    public function testEquals() {
        $matchScoreComparator = new MatchScoreComparator();
        
        $matchScoreMedium = new MatchScore();
        $matchScoreMinor = new MatchScore($matchScoreMedium->getNumericValue() - 1);
        $matchScoreMajor = new MatchScore($matchScoreMedium->getNumericValue() + 1);

        $resultEqual = $matchScoreComparator->equals($matchScoreMedium, $matchScoreMedium);
        $this->assertEquals($resultEqual, true);

        $resultLessThan = $matchScoreComparator->equals($matchScoreMedium, $matchScoreMajor);
        $this->assertEquals($resultLessThan, false);

        $resultMoreThan = $matchScoreComparator->equals($matchScoreMedium, $matchScoreMinor);
        $this->assertEquals($resultMoreThan, false);
    }
}
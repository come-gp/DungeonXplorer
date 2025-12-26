<?php 

function base_url(string $path = ''): string {
    return '/DungeonXplorer/public' . $path;
}

// nb d'exp pour le prochain niveau ( 1O puis 15 puis 20 etc)
function getXpForLevel(int $level): int {
    if ($level <= 1) {
        return 0;
    }
    
    $totalXp = 0;
    $xpIncrement = 10; 
    
    for ($i = 2; $i <= $level; $i++) {
        $totalXp += $xpIncrement;
        $xpIncrement += 5; 
    }
    
    return $totalXp;
}

// donne le niveau actuel 
function getLevelFromXp(int $currentXp): int {
    $level = 1;
    
    while (getXpForLevel($level + 1) <= $currentXp) {
        $level++;
    }
    
    return $level;
}

//donne l'xp pour le prochain niveau
function getXpForNextLevel(int $level): int {
    return getXpForLevel($level + 1);
}


function getXpInCurrentLevel(int $currentXp, int $level): int {
    $xpForCurrentLevel = getXpForLevel($level);
    return $currentXp - $xpForCurrentLevel;
}


function getXpNeededForNextLevel(int $currentXp, int $level): int {
    $xpForCurrentLevel = getXpForLevel($level);
    $xpForNextLevel = getXpForLevel($level + 1);
    return $xpForNextLevel - $xpForCurrentLevel;
}
?>
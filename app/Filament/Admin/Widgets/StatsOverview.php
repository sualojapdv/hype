<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    /*** @return array|Stat[]
     */
    protected function getStats(): array
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        $totalApostas = Order::whereIn('type', ['bet', 'loss'])->sum('amount');
        $totalWins = Order::where('type', 'win')->sum('amount');
        $today = Carbon::today();

        $totalWonLast7Days = $totalWins;
        $totalLoseLast7Days = $totalApostas;

        $saldodosplayers = DB::table('users')->join('wallets', function ($join) {$join->on('users.id', '=', 'wallets.user_id')
             ->where('users.id', '!=', 1)
             ->where('users.is_demo_agent', 0);
    })
             ->where('wallets.balance_withdrawal', '>=', 20)
             ->sum('wallets.balance_withdrawal');
        
        $totalDepositedToday = DB::table('deposits')
            ->whereDate('created_at', $today)
            ->where('status', '1') // Filtrar apenas os depósitos aprovados
            ->sum('amount');
        $totalsacadoToday = DB::table('withdrawals')
            ->whereDate('created_at', $today)
            ->where('status', '1') // Filtrar apenas os depósitos aprovados
            ->sum('amount');
$totalReferRewardsLast7Days = DB::table('wallets')
    ->where('refer_rewards', '>=', 40) // Adicione esta linha para filtrar apenas os valores maiores ou iguais a 20
    ->sum('refer_rewards');

$depositCounts = DB::table('deposits')
    ->select('user_id', DB::raw('count(*) as deposit_count'))
    ->where('status', '1')
    ->groupBy('user_id')
    ->get();

$usersWithSingleDeposit = $depositCounts->filter(function ($item) {
    return $item->deposit_count === 1;
});

$numberOfUsersWithSingleDeposit = $usersWithSingleDeposit->count();

$usersWithTwoDeposits = $depositCounts->filter(function ($item) {
    return $item->deposit_count === 2;
});
$numberOfUsersWithTwoDeposits = $usersWithTwoDeposits->count();

$usersWithThreeDeposits = $depositCounts->filter(function ($item) {
    return $item->deposit_count === 3;
});
$numberOfUsersWithThreeDeposits = $usersWithThreeDeposits->count();

$usersWithFourOrMoreDeposits = $depositCounts->filter(function ($item) {
    return $item->deposit_count >= 4;
});
$numberOfUsersWithFourOrMoreDeposits = $usersWithFourOrMoreDeposits->count();

// Soma dos depósitos confirmados de 5, 10, 20 e acima de 30 reais
$confirmedDepositsTotal5 = DB::table('deposits')
    ->where('status', 1)
    ->where('amount', 5)
    ->sum('amount');

$confirmedDepositsTotal10 = DB::table('deposits')
    ->where('status', 1)
    ->where('amount', 10)
    ->sum('amount');

$confirmedDepositsTotal20 = DB::table('deposits')
    ->where('status', 1)
    ->where('amount', 20)
    ->sum('amount');

$confirmedDepositsTotalAbove30 = DB::table('deposits')
    ->where('status', 1)
    ->where('amount', '>', 30)
    ->sum('amount');

        return [
            Stat::make('Total Usuários', User::count())
                ->description('Novos usuários')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Total Depositado Hoje', \Helper::amountFormatDecimal($totalDepositedToday))
                ->description('Total depositado hoje')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Total Sacado Hoje', \Helper::amountFormatDecimal($totalsacadoToday))
                ->description('Total depositado hoje')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Saldo dos Players', \Helper::amountFormatDecimal($saldodosplayers))
                ->description('Saldo dos players disponível para saque')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Ganhos Afiliados a pagar', \Helper::amountFormatDecimal($totalReferRewardsLast7Days))
                ->description('Ganhos dos Afiliado a pagar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Pessoas Que Depositaram 1 Vez', $numberOfUsersWithSingleDeposit)
                ->description('Pessoas Que Depositaram 1 Vez')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Pessoas Que Depositaram 2 Vezes', $numberOfUsersWithTwoDeposits)
                ->description('Pessoas Que Depositaram 2 Vezes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Pessoas Que Depositaram 3 Vezes', $numberOfUsersWithThreeDeposits)
                ->description('Pessoas Que Depositaram 3 Vezes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Pessoas Que Depositaram 4 Vezes ou mais', $numberOfUsersWithFourOrMoreDeposits)
                ->description('Pessoas Que Depositaram 4 Vezes ou mais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Total de Depósitos Confirmados de 5 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotal5))
                ->description('Total de depósitos confirmados de 5 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Total de Depósitos Confirmados de 10 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotal10))
                ->description('Total de depósitos confirmados de 10 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Total de Depósitos Confirmados de 20 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotal20))
                ->description('Total de depósitos confirmados de 20 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Total de Depósitos Confirmados Acima de 30 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotalAbove30))
                ->description('Total de depósitos confirmados acima de 30 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),

        ];
    }

    /**
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}

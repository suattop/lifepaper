@extends('layouts.app')
@section('title', '我的命盤')

@section('content')

<div class="container">
    <div class="pt-2 pb-5 ziwei">
        <div class="row">
            <div class="col-lg-6 col-sm-12 mt-3 mb-3">
                <div class="card star-card h-100">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bolder">你</h5>
                        <p class="card-text">
                            {{ $destiny->born_year }}年{{ $destiny->born_month }}月{{ $destiny->born_day }}日{{ $destiny->born_hour }}時出生
                        </p>
                        <p class="card-text">
                            {{ $destiny->year_stem }}{{ $destiny->year_branch }}年
                            {{ $destiny->month_stem }}{{ $destiny->month_branch }}月
                            {{ $destiny->day_stem }}{{ $destiny->day_branch }}日
                            {{ $destiny->hour_stem }}{{ $destiny->hour_branch }}時
                        </p>
                        <p class="card-text">
                            {{ $analysis->basic_character }}
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 mt-3 mb-3">
                <div class="card sky-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">糾纏自己一生的問題</h5>
                        <p class="card-text">{{ $spinning->description }}</p>
                        <h5 class="card-title">內心空缺</h5>
                        <p class="card-text">{{ $lack->description }}</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 mt-3 mb-3">
                <div class="card city-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">家庭:</h5>
                        <p class="card-text">{{ $analysis->brother }}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12 mt-3 mb-3">
                <div class="card h-100 sea-card">
                    <div class="card-body">
                        <h5 class="card-title">愛情:</h5>
                        <p class="card-text">{{ $analysis->relationship }}</p>
                        @if (!empty($love_results))
                        @foreach ($love_results as $love_result)
                        <p class="card-text">{{ $love_result }}</p>
                        @endforeach
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 mt-3 mb-3">
                <div class="card work-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">事業:</h5>
                        @if (!empty($career_results))
                        @foreach ($career_results as $career_result)
                        <p class="card-text">{{ $career_result }}</p>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 mt-3 mb-3">
                <div class="card gold-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">理財:</h5>
                        @if (!empty($money_results))
                        @foreach ($money_results as $money_result)
                        <p class="card-text">{{ $money_result }}</p>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion years" id="year">
            @foreach ($ziweis as $ziwei)
            <div class="card">
                <div class="card-header" id="heading{{ $ziwei->id }}">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $ziwei->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $ziwei->id }}">
                            <Strong>{{ $ziwei->stem }}{{ $ziwei->branch }}運</strong> {{ $ziwei->begin_age }}歲-{{ $ziwei->end_age }}歲
                            <p style= "margin-bottom: 0rem;">
                            {{ $ziwei->palace }}
                            @foreach ($ziwei->stars as $star)
                            {{ $star->name }}@isset($star->four_change){{ $star->four_change }}
                            @endisset
                            @endforeach
                            </p>
                        </button>
                    </h2>
                </div>
                <div id="collapse{{ $ziwei->id }}" class="collapse" aria-labelledby="heading{{ $ziwei->id }}"
                    data-parent="#year">
                    <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop
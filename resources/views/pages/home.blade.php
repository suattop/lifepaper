@extends('layouts.app')
@section('title', '首页')

@section('content')
<div class="slider pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="left col-md-6 col-lg-8 col-sm-12">
                <div class="p-5 slogan">
                    <h1>命運全在紙上</h1>
                    <h2>把握優缺點、掌握自己的人生</h2>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="m-3 pt-5 pb-5 pl-4 pr-4 first-form ">
                    <h3 class="pb-5 mx-auto font-weight-bold">取得您的命紙</h3>
                    <form action="{{ route('destiny.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 col-12 mb-3 box">
                                <label for="password">性別</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="m">男</option>
                                    <option value="f">女</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12 mb-3 box">
                                <label for="born_year">年</label>
                                <select class="form-control" name="born_year" id="years">
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                    <option value="1981">1981</option>
                                    <option value="1980">1980</option>
                                    <option value="1979">1979</option>
                                    <option value="1978">1978</option>
                                    <option value="1977">1977</option>
                                    <option value="1976">1976</option>
                                    <option value="1975">1975</option>
                                    <option value="1974">1974</option>
                                    <option value="1973">1973</option>
                                    <option value="1972">1972</option>
                                    <option value="1971">1971</option>
                                    <option value="1970">1970</option>
                                    <option value="1969">1969</option>
                                    <option value="1968">1968</option>
                                    <option value="1967">1967</option>
                                    <option value="1966">1966</option>
                                    <option value="1965">1965</option>
                                    <option value="1964">1964</option>
                                    <option value="1963">1963</option>
                                    <option value="1962">1962</option>
                                    <option value="1961">1961</option>
                                    <option value="1960">1960</option>
                                    <option value="1959">1959</option>
                                    <option value="1958">1958</option>
                                    <option value="1957">1957</option>
                                    <option value="1956">1956</option>
                                    <option value="1955">1955</option>
                                    <option value="1954">1954</option>
                                    <option value="1953">1953</option>
                                    <option value="1952">1952</option>
                                    <option value="1951">1951</option>
                                    <option value="1950">1950</option>
                                    <option value="1949">1949</option>
                                    <option value="1948">1948</option>
                                    <option value="1947">1947</option>
                                    <option value="1946">1946</option>
                                    <option value="1945">1945</option>
                                    <option value="1944">1944</option>
                                    <option value="1943">1943</option>
                                    <option value="1942">1942</option>
                                    <option value="1941">1941</option>
                                    <option value="1940">1940</option>
                                    <option value="1939">1939</option>
                                    <option value="1938">1938</option>
                                    <option value="1937">1937</option>
                                    <option value="1936">1936</option>
                                    <option value="1935">1935</option>
                                    <option value="1934">1934</option>
                                    <option value="1933">1933</option>
                                    <option value="1932">1932</option>
                                    <option value="1931">1931</option>
                                    <option value="1930">1930</option>
                                    <option value="1929">1929</option>
                                    <option value="1928">1928</option>
                                    <option value="1927">1927</option>
                                    <option value="1926">1926</option>
                                    <option value="1925">1925</option>
                                    <option value="1924">1924</option>
                                    <option value="1923">1923</option>
                                    <option value="1922">1922</option>
                                    <option value="1921">1921</option>
                                    <option value="1920">1920</option>
                                    <option value="1919">1919</option>
                                    <option value="1918">1918</option>
                                    <option value="1917">1917</option>
                                    <option value="1916">1916</option>
                                    <option value="1915">1915</option>
                                    <option value="1914">1914</option>
                                    <option value="1913">1913</option>
                                    <option value="1912">1912</option>
                                    <option value="1911">1911</option>
                                    <option value="1910">1910</option>
                                    <option value="1909">1909</option>
                                    <option value="1908">1908</option>
                                    <option value="1907">1907</option>
                                    <option value="1906">1906</option>
                                    <option value="1905">1905</option>
                                    <option value="1904">1904</option>
                                    <option value="1903">1903</option>
                                    <option value="1902">1902</option>
                                    <option value="1901">1901</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12 mb-3 box">
                                <label for="born_month">月</label>
                                <select class="form-control" name="born_month" id="months">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12 mb-3 box">
                                <label for="born_day">日</label>
                                <select class="form-control" name="born_day" id="days">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col mb-3 box">
                                <label for="born_hour">時間</label>
                                <select class="form-control" name="born_hour">
                                    <option value="0">0時 - 子</option>
                                    <option value="1">1時 - 丑</option>
                                    <option value="2">2時 - 丑</option>
                                    <option value="3">3時 - 寅</option>
                                    <option value="4">4時 - 寅</option>
                                    <option value="5">5時 - 卯</option>
                                    <option value="6">6時 - 卯</option>
                                    <option value="7">7時 - 辰</option>
                                    <option value="8">8時 - 辰</option>
                                    <option value="9">9時 - 巳</option>
                                    <option value="10">10時 - 巳</option>
                                    <option value="11">11時 - 午</option>
                                    <option value="12">12時 - 午</option>
                                    <option value="13">13時 - 未</option>
                                    <option value="14">14時 - 未</option>
                                    <option value="15">15時 - 申</option>
                                    <option value="16">16時 - 申</option>
                                    <option value="17">17時 - 酉</option>
                                    <option value="18">18時 - 酉</option>
                                    <option value="19">19時 - 戌</option>
                                    <option value="20">20時 - 戌</option>
                                    <option value="21">21時 - 亥</option>
                                    <option value="22">22時 - 亥</option>
                                    <option value="23">23時 - 下一日的子</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="mx-auto mt-4 w-100 btn btn-primary">
                            了解更多你自己
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main pt-5 pb-5">
    <div class="container">
        <h2 class="explain"><span class="title">全面分析命運一切</span></h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card h-100">
                    <img class="card-img-top"
                        src="https://images.pexels.com/photos/839671/pexels-photo-839671.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title text-center">基本性格</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img class="card-img-top"
                        src="https://images.pexels.com/photos/2089891/pexels-photo-2089891.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title text-center">工作分析</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img class="card-img-top"
                        src="https://images.pexels.com/photos/2512282/pexels-photo-2512282.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title text-center">情感關係</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
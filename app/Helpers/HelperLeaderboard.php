<?php

    use App\Models\SiteConfiguration;
    use App\Models\Dealership;
    use App\Models\Competition;
    use App\Models\SaleLeague;
    use App\Leaderboard;

    //Returns a competition image
    function competition_image($user_id, $filename){

        //Image path if there's only one competition
        $path               =   asset('assets/images/public/general/') ."/".$filename;

        //Query to check the amount of competitions
        $competitions       =   Competition::select('competitions.*')
                                    ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                    ->where('competition_leaderboard.leaderboard_id', $user_id)
                                    ->where('competitions.active', 1)
                                    ->orderBy('name', 'ASC')
                                    ->get();


        //Checks if there's more than one competition
        if($competitions->count() > 1) {

            //Gets the first competition
            $competition       =   Competition::select('competitions.*')
                                        ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                        ->where('competition_leaderboard.leaderboard_id', $user_id)
                                        ->orderBy('competitions.name', 'ASC')
                                        ->where('competitions.active', 1)->first();

            //Gets the image matching $competition->id
            $image              =   DB::table('competition_images')
                                        ->where('competition_images.competition_id', $competition->id)
                                        ->first();

            //Sets the new image $path
            $path               =   asset('assets/images/public/general/') ."/".$image->filename;

            //Echo's image
            echo '<img src="'.$path.'" alt="" class="block mb-4 border border-white shadow ">';
        }else{

            //Echo's image if there's only one Competition
            echo '<img src="'.$path.'" alt="" class="block mb-4 border border-white shadow ">';
        }

    }


    function competition_sale_leagues()
    {
        //

        $exec               =   auth('leaderboard')->user();


        $dealership         =   Dealership::where('code', $exec->dealership_code)->first();

                //Query to check the amount of competitions
        $competitions       =   Competition::select('competitions.*')
                                    ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                    ->where('competition_leaderboard.leaderboard_id', $exec->id)
                                    ->where('competitions.active', 1)
                                    ->orderBy('name', 'ASC')
                                    ->get();

        //return $competitions;



        //Checks if there's more than one competition
        if($competitions->count() > 1 ) {

                $competition        =   Competition::select('competitions.*')
                                            ->join('competition_leaderboard', 'competition_leaderboard.competition_id', 'competitions.id')
                                            ->where('competition_leaderboard.leaderboard_id', $exec->id)
                                            ->orderBy('name', 'ASC')
                                            ->where('competitions.active', 1)->first();

                $sales              =   SaleLeague::select('sale_leagues.*', DB::raw('count(sale_leagues.leaderboard_id) as total'))
                                            ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'sale_leagues.leaderboard_id')
                                            ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                                            ->where('competition_leaderboard.competition_id', $competition->id)
                                            ->groupBy('sale_leagues.leaderboard_id')
                                            ->orderBy('total', 'DESC')
                                            //->orderBy('sale_leagues.leaderboard_id', 'DESC')
                                            ->get();



                return view('leaderboard.sales-league._show-competition-league')
                                            ->with('competition', $competition)
                                            ->with('exec', $exec)
                                            ->with('dealership', $dealership)
                                            ->with('sales', $sales);


        }else{
            return "";
        }

        //return $competition->name;




    }


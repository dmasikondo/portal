<section class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <form action="#" class="number-tab-steps wizard-circle wizard clearfix" role="application"
                      id="steps-uid-0">
                    <div class="steps clearfix">
                        <ul role="tablist">
                            @php($stages = \App\UserProfileUpdatePlan::whereUserId(Auth::id())->orderBy('stage','asc')->get())

                            @foreach($stages as $stage)
                                <li role="tab"
                                    class="disabled {{($loop->index==0)?"first":""}} {{($loop->index==($loop->count-1))?"last":""}} {{($stage->status =="C")?"done":""}} {{($stage->status =="A")?"current":""}}"
                                    aria-disabled="false"
                                    aria-selected="true">
                                    <a aria-controls="steps-uid-0-p-{{$loop->iteration}}">
                                        @if($stage->status =="A")
                                            <span class="current-info audible">current stage: </span>
                                        @endif
                                        <span class="step">{{$stage->stage}}</span> Stage {{$stage->stage}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div>
    <li class="nav-item">
        <div class="dropdown">
            <a style="color: #D4D4DF; font-size: 13px; font-weight: 500; padding-top: 12px;" data-tooltip="Notificações" data-flow="bottom" class="nav-link pl-1" role="button" id="drop_notifications" data-toggle="dropdown" aria-expanded="false">
                <i style="font-size: 21px !important; line-height: .75em !important; vertical-align: -.0667em !important;" class="fal fa-bell"></i>
                @if ($notificacoes_not_read != 0)
                    <div class="ball-notification">
                        {{$notificacoes_not_read}}
                    </div>
                @endif
            </a>
            <div style="padding: 0px !important; max-width: 350px !important; min-width: 350px !important;" class="dropdown-menu" aria-labelledby="drop_notifications">                        
               <div class="div-not-read text-center">
                   <span style="color: #666;"><span class="mr-1" style="color: #725BC2; font-weight: 600; font-size: 20px;">{{$notificacoes_not_read}}</span> notificações não lidas</span>
               </div>
               <div class="div-notifications-box">
                
                    @if ($notificacoes->count())
                        <a href="{{route('notificacoes')}}">
                            <div class="div-has-notifications">
                                @foreach ($notificacoes as $notificacao)
                                    
                                    <div class="div-single-notification">
                                        <span>{!!$notificacao->content!!}</span>
                                    </div>    

                                @endforeach                  
                            </div>
                        </a>
                    @else
                        <div style="user-select: none;" class="div-zero-notifications text-center py-5">
                            <i style="color: #725BC2;" class="fad fa-bell fa-fw fa-lg mr-1 mb-2"></i>
                            <br>
                            <span style="color: #666; font-size: 15px;">Tudo limpo! Nenhuma nova notificação.</span>
                    </div>
                    @endif

               </div>
               <a href="{{route('notificacoes')}}">
                <div class="div-see-all-notifications text-center">
                    <span>Ver todas</span><i style="font-size: 13px;" class="fal fa-chevron-right fa-fw ml-1"></i>
                </div>
                </a>
            </div>
        </div> 
    </li>
</div>

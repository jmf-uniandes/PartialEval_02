import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IEvent } from '../Interfaces/ievent';
import { EventsService } from '../Services/eventos.service';
import Swal from 'sweetalert2';
@Component({
  selector: 'app-eventos',
  standalone: true,
  imports: [RouterLink, SharedModule],
  templateUrl: './eventos.component.html',
  styleUrl: './eventos.component.scss'
})
export class EventsComponent {
  listaevents: IEvent[] = [];
  constructor(private eventServicio: EventsService) {}

  ngOnInit() {
    this.cargatabla();
  }
  cargatabla() {
    this.eventServicio.todos().subscribe((data) => {
      console.log(data);
      this.listaevents = data;
    });
  }
  eliminar(idEvents) {
    Swal.fire({
      title: 'Eventos',
      text: 'Esta seguro que desea eliminar el evento?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar Evento'
    }).then((result) => {
      if (result.isConfirmed) {
        this.eventServicio.eliminar(idEvents).subscribe((data) => {
          Swal.fire('Clientes', 'El evento ha sido eliminado.', 'success');
          this.cargatabla();
        });
      }
    });
  }
}

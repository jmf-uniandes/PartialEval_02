import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IReservation } from '../Interfaces/ireservation';
import { ReservationsService } from '../Services/reservas.service';
import Swal from 'sweetalert2';
@Component({
  selector: 'app-reservas',
  standalone: true,
  imports: [RouterLink, SharedModule],
  templateUrl: './reservaciones.component.html',
  styleUrl: './reservaciones.component.scss'
})
export class ReservaComponent {
  listareservations: IReservation[] = [];
  constructor(private eventServicio: ReservationsService) {}

  ngOnInit() {
    this.cargatabla();
  }
  cargatabla() {
    this.eventServicio.todos().subscribe((data) => {
      console.log(data);
      this.listareservations = data;
    });
  }
  eliminar(idEvents) {
    Swal.fire({
      title: 'Reservaciones',
      text: 'Esta seguro que desea eliminar la reservacion?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar Reserva'
    }).then((result) => {
      if (result.isConfirmed) {
        this.eventServicio.eliminar(idEvents).subscribe((data) => {
          Swal.fire('Clientes', 'La reserva ha sido eliminada.', 'success');
          this.cargatabla();
        });
      }
    });
  }
}

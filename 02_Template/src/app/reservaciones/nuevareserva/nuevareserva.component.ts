import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule, ValidationErrors, Validators } from '@angular/forms';

import { ReservationsService } from 'src/app/Services/reservas.service';  
import { IReservation } from 'src/app/Interfaces/ireservation'; 
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';
import { ActivatedRoute, Router } from '@angular/router';
import { SharedModule } from 'src/app/theme/shared/shared.module';


@Component({
  selector: 'app-nuevareserva',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './nuevareserva.component.html',
  styleUrl: './nuevareserva.component.scss'
})
export class NuevareservaComponent implements OnInit {
  frm_Reserva = new FormGroup({
    //idReservations: new FormControl(),
    clients_idClients: new FormControl('', Validators.required),
    events_idReservations: new FormControl('', Validators.required),
    //event_location: new FormControl('', Validators.required),
    reservationStatus: new FormControl('', Validators.required),
    //event_status: new FormControl('', Validators.required)
  });
  
  idReservations = 0;
  titulo = 'Nueva Reserva';
  constructor(
    private reservaServicio: ReservationsService,
    private navegacion: Router,
    private ruta: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.idReservations = parseInt(this.ruta.snapshot.paramMap.get('idReservations'));
    if (this.idReservations > 0) {
        this.reservaServicio.uno(this.idReservations).subscribe((unareserva) => {
        this.frm_Reserva.controls['clients_idClients'].setValue(unareserva.clients_idClients.toString());
        this.frm_Reserva.controls['events_idReservations'].setValue(unareserva.events_idEvents.toString());
        //this.frm_Reserva.controls['event_location'].setValue(unareserva.event_location);       
        this.frm_Reserva.controls['reservationStatus'].setValue(unareserva.reservationStatus.toString());
        //this.frm_Reserva.controls['event_status'].setValue(unareserva.event_status.toString());  
        this.titulo = 'Editar Evento ' + this.idReservations ;
      });
    }
     else
     {
      this.titulo = 'Nuevo Evento';
       this.idReservations =0;
     }
  }

  grabar() {
    
    let evento: IReservation = {
      idReservations: this.idReservations,
      clients_idClients: Number(this.frm_Reserva.controls['clients_idClients'].value),
      events_idEvents: Number(this.frm_Reserva.controls['events_idReservations'].value),
      //event_location: this.frm_Reserva.controls['event_location'].value,
      reservationStatus: Number(this.frm_Reserva.controls['reservationStatus'].value),
      //event_status: this.frm_Reserva.controls['event_status'].value
       
     
    };

    Swal.fire({
      title: 'Reservaciones',
      //text: 'Desea guardar la reserva ' + this.frm_Reserva.controls['clients_idClients'].value +'?',
      text: 'Desea guardar la reserva ' + this.frm_Reserva.controls['clients_idClients'].value +'?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.idReservations > 0) {
          this.reservaServicio.actualizar(evento).subscribe((res: any) => {
            Swal.fire({
              title: 'eventos',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/eventos']);
          });
        } else {
          this.reservaServicio.insertar(evento).subscribe((res: any) => {
            Swal.fire({
              title: 'eventos',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/eventos']);
          });
        }
      }
    });
  }

  
}

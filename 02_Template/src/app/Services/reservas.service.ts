import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IReservation } from '../Interfaces/ireservation';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReservationsService {
  apiurl = 'http://localhost/UniAndes/PartialEval_02/01_MVC/controllers/reservations.controller.php?op=';
  constructor(private lector: HttpClient) {}

  buscar(texto: string): Observable<IReservation> {
    const formData = new FormData();
    formData.append('texto', texto);
    return this.lector.post<IReservation>(this.apiurl + 'uno', formData);
  }

  todos(): Observable<IReservation[]> {
    return this.lector.get<IReservation[]>(this.apiurl + 'todos');
  }
  uno(idReservations: number): Observable<IReservation> {
    const formData = new FormData();
    formData.append('idReservations', idReservations.toString());
    return this.lector.post<IReservation>(this.apiurl + 'uno', formData);
  }
  eliminar(idReservations: number): Observable<number> {
    const formData = new FormData();
    formData.append('idReservations', idReservations.toString());
    return this.lector.post<number>(this.apiurl + 'eliminar', formData);
  }
  insertar(reserva: IReservation): Observable<string> {
    const formData = new FormData();
    formData.append('idReservations', reserva.idReservations.toString());
    formData.append('clients_idClients', reserva.clients_idClients.toString());
    formData.append('events_IdEvents', reserva.events_idEvents.toString());
    formData.append('reservationStatus', reserva.reservationStatus.toString());
    // debug query
   console.log(this.apiurl + 'actualizar');
   formData.forEach((value, key) => {
     console.log(`${key}: ${value}`);
   });
   //--
    return this.lector.post<string>(this.apiurl + 'insertar', formData);
  }
    actualizar(reserva: IReservation): Observable<string> {
    const formData = new FormData();
    formData.append('idReservations', reserva.idReservations.toString());
    formData.append('clients_idClients', reserva.clients_idClients.toString());
    formData.append('events_IdEvents', reserva.events_idEvents.toString());
    formData.append('reservationStatus', reserva.reservationStatus.toString());
    console.log('actualizar:');

    // debug query
    console.log(this.apiurl + 'actualizar');
    formData.forEach((value, key) => {
      console.log(`${key}: ${value}`);
    });
    //--

    return this.lector.post<string>(this.apiurl + 'actualizar', formData);
  }
}

import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IEvent } from '../Interfaces/ievent';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EventsService {
  apiurl = 'http://localhost/UniAndes/PartialEval_02/01_MVC/controllers/events.controller.php?op=';
  constructor(private lector: HttpClient) {}

  buscar(texto: string): Observable<IEvent> {
    const formData = new FormData();
    formData.append('texto', texto);
    return this.lector.post<IEvent>(this.apiurl + 'uno', formData);
  }

  todos(): Observable<IEvent[]> {
    return this.lector.get<IEvent[]>(this.apiurl + 'todos');
  }
  uno(idEvents: number): Observable<IEvent> {
    const formData = new FormData();
    formData.append('idEvents', idEvents.toString());
    return this.lector.post<IEvent>(this.apiurl + 'uno', formData);
  }
  eliminar(idEvents: number): Observable<number> {
    const formData = new FormData();
    formData.append('idEvents', idEvents.toString());
    return this.lector.post<number>(this.apiurl + 'eliminar', formData);
  }
  insertar(evento: IEvent): Observable<string> {
    const formData = new FormData();
    formData.append('idEvents', evento.idEvents.toString());
    formData.append('event_name', evento.event_name);
    formData.append('event_description', evento.event_description);
    formData.append('event_date', evento.event_date);
    formData.append('event_location', evento.event_location);
    formData.append('event_status', evento.event_status);
    //`event_name`, `event_description`, `event_date`, `event_location`, `event_status`
    
   //console.log('insertar' + formData);
    return this.lector.post<string>(this.apiurl + 'insertar', formData);
  }
    actualizar(evento: IEvent): Observable<string> {
    const formData = new FormData();
    formData.append('idEvents', evento.idEvents.toString());
    formData.append('event_name', evento.event_name);
    formData.append('event_description', evento.event_description);
    formData.append('event_date', evento.event_date);
    formData.append('event_location', evento.event_location);
    formData.append('event_status', evento.event_status);
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

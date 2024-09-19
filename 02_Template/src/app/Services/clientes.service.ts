import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

import { ICliente } from '../Interfaces/icliente';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ClientesService {
  //apiurl = 'http://localhost/UniAndes/WeeklyAssignments/03MVC/controllers/clientes.controller.php?op=';
  apiurl = 'http://localhost/UniAndes/PartialEval_02/01_MVC/controllers/clientes.controller.php?op=';
  constructor(private lector: HttpClient) {}

  buscar(texto: string): Observable<ICliente> {
    const formData = new FormData();
    formData.append('texto', texto);
    return this.lector.post<ICliente>(this.apiurl + 'uno', formData);
  }

  todos(): Observable<ICliente[]> {
    return this.lector.get<ICliente[]>(this.apiurl + 'todos');
  }
  uno(idClients: number): Observable<ICliente> {
    const formData = new FormData();
    formData.append('idClients', idClients.toString());
    return this.lector.post<ICliente>(this.apiurl + 'uno', formData);
  }
  eliminar(idClients: number): Observable<number> {
    const formData = new FormData();
    formData.append('idClients', idClients.toString());
    return this.lector.post<number>(this.apiurl + 'eliminar', formData);
  }
  insertar(cliente: ICliente): Observable<string> {
    const formData = new FormData();
    formData.append('idClients', cliente.idClients.toString());
    formData.append('client_name', cliente.client_name);
    formData.append('client_surename', cliente.client_surename);
    formData.append('client_email', cliente.client_email);
    formData.append('client_phonenumber', cliente.client_phonenumber);
    
   // debug query
  //  console.log(this.apiurl + 'actualizar');
  //  formData.forEach((value, key) => {
  //    console.log(`${key}: ${value}`);
  //  });
    return this.lector.post<string>(this.apiurl + 'insertar', formData);
  }
  actualizar(cliente: ICliente): Observable<string> {
    const formData = new FormData();
    formData.append('idClients', cliente.idClients.toString());
    formData.append('client_name', cliente.client_name);
    formData.append('client_surename', cliente.client_surename);
    formData.append('client_email', cliente.client_email);
    formData.append('client_phonenumber', cliente.client_phonenumber);
    console.log('actualizar:');

    // // debug query
    // console.log(this.apiurl + 'actualizar');
    // formData.forEach((value, key) => {
    //   console.log(`${key}: ${value}`);
    // });
    //--

    return this.lector.post<string>(this.apiurl + 'actualizar', formData);
  }
}

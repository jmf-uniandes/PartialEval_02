import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule, ValidationErrors, Validators } from '@angular/forms';
import { EventsService } from 'src/app/Services/eventos.service';
import { IEvent } from 'src/app/Interfaces/ievent';
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';
import { ActivatedRoute, Router } from '@angular/router';
import { SharedModule } from 'src/app/theme/shared/shared.module';


@Component({
  selector: 'app-nuevoevento',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './nuevoevento.component.html',
  styleUrl: './nuevoevento.component.scss'
})
export class NuevoeventoComponent implements OnInit {
  frm_Evento = new FormGroup({
    //idEvents: new FormControl(),
    event_name: new FormControl('', Validators.required),
    event_description: new FormControl('', Validators.required),
    event_location: new FormControl('', Validators.required),
    event_date: new FormControl('', Validators.required),
    event_status: new FormControl('', Validators.required)
  });
  
  idEvents = 0;
  titulo = 'Nuevo Evento';
  constructor(
    private eventoServicio: EventsService,
    private navegacion: Router,
    private ruta: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.idEvents = parseInt(this.ruta.snapshot.paramMap.get('idEvents'));
    if (this.idEvents > 0) {
        this.eventoServicio.uno(this.idEvents).subscribe((unevento) => {
        this.frm_Evento.controls['event_name'].setValue(unevento.event_name);
        this.frm_Evento.controls['event_description'].setValue(unevento.event_description);
        this.frm_Evento.controls['event_location'].setValue(unevento.event_location);       
        this.frm_Evento.controls['event_date'].setValue(unevento.event_date);
        this.frm_Evento.controls['event_status'].setValue(unevento.event_status);  
        this.titulo = 'Editar Evento ' + this.idEvents ;
      });
    }
     else
     {
      this.titulo = 'Nuevo Evento';
       this.idEvents =0;
     }
  }

  grabar() {
    
    let evento: IEvent = {
      idEvents: this.idEvents,
      event_name: this.frm_Evento.controls['event_name'].value,
      event_description: this.frm_Evento.controls['event_description'].value,
      event_location: this.frm_Evento.controls['event_location'].value,
      event_date: this.frm_Evento.controls['event_date'].value,
      event_status: this.frm_Evento.controls['event_status'].value
           
    };

    Swal.fire({
      title: 'Eventos',
      text: 'Desea guardar el Evento ' + this.frm_Evento.controls['event_name'].value +'?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.idEvents > 0) {
          this.eventoServicio.actualizar(evento).subscribe((res: any) => {
            Swal.fire({
              title: 'eventos',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/eventos']);
          });
        } else {
          this.eventoServicio.insertar(evento).subscribe((res: any) => {
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

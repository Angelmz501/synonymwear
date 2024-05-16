import { Component } from '@angular/core';
import {
  FormBuilder,
  FormGroup,
  Validators,
} from '@angular/forms';

import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
 public loginForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router
  ) {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(2)]],
    });
  }

  async onSubmit(): Promise<void> {
    if (this.loginForm.valid) {
      try {
        const response = await this.authService.login(
          this.loginForm.value.email,
          this.loginForm.value.password
        );
        console.log('Login exitoso:', response);
        localStorage.setItem('jwt_token', response.jwt);
        this.router.navigate(['/home']);
      } catch (error) {
        console.error('Error en el login:', error);
      }
    }
  }
}

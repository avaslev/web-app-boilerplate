import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'app-spinner',
  templateUrl: './spinner.component.html',
  styleUrls: ['./spinner.component.scss']
})
export class SpinnerComponent implements OnInit {

  @Input() isLoading = false;
  @Input() message: any;

  constructor() {
  }

  public ngOnInit(): void {
  }

}

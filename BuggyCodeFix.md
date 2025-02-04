First error Namespace Typo  from namespace App\Https\Controllers; and use Illuminate\Https\Request;

while storing and updating missing Validation

Assignment error, from both store and update function

Task may likely Not-Found from  update and destroy methods


Optimizing Code:

    For simplicity, i use Task::create() instead of manually setting the properties for the store method.
    In the update method, the properties can be mass-assigned using the update() method instead of manually setting each one.
    Added a unified responds formate and a try and catch (incase of any on for seen error)

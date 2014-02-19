
class MathCaptchaComponentTest extends CakeTestCase {

  public function setUp() {
    parent::setUp();
    $Controller = new Controller();
    $View = new View($Controller);
    $this->MathCaptcha = new MathCaptchaHelper($View);
  }
  public function testGenerateEquation() {
    $result = $this->MathCaptcha->generateEquation();
    debug($result);
  } 
}
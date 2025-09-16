<?php
require_once __DIR__ . '/../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="../assets/favicon-mit.ico" />
  <title>MITSDE — Newsletter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
  


  <link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL . '/assets/css/styles.css') ?>">
</head>

<body>
  <?php include __DIR__ . '/../inc/header.php'; ?>

  <section class="hero bg-light">
    <div class="container">
      <h1 class="display-5 fw-bold">Weekly tech & AI updates</h1>
      <p class="lead">Curated AI tools, short reads, and product updates.</p>
      <div class="mt-3">
        <button class="btn btn-primary btn-lg me-2" data-bs-toggle="modal" data-bs-target="#aiToolsModal">New AI Tools — This Week</button>

      </div>
    </div>
  </section>

  <section class="py-5 bg-light">

    <div class="container">
      <div class="row g-4">

        <!-- Main Content -->
        <div class="col-lg-8">
          <div class="card p-4 shadow-lg rounded-4 newsletter-preview hover-shadow">
            <h3 class="fw-bold mb-3">This Week’s Insight</h3>
            <p>Short explainer and why it's useful.</p>
            <img src="../assets/ChatGPT.png" class="img-fluid rounded-3 mb-3 shadow-sm  banner" alt="banner">
            <a href="#" class="btn btn-primary btn-gradient shadow-sm hover-scale">Read Full Story</a>
          </div>


        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <div class="card p-3 shadow-sm rounded-4 hover-shadow mb-3">
            <h5 class="fw-bold">Why subscribe?</h5>
            <p class="small text-muted">Short, practical, curated. No spam.</p>
            <button class="btn btn-primary w-100 btn-gradient shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#subscribeModal">
              Subscribe — Free
            </button>
          </div>

          <div class="card p-3 shadow-sm rounded-4 hover-shadow">
            <!-- <h6 class="fw-bold">Newsletter Preview</h6> -->
            <!-- <p class="small text-muted">Image, short text and CTA</p> -->
            <img src="../assets/newsletter.png" class="img-fluid rounded-3 shadow-sm" alt="preview">
          </div>
        </div>

      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <!-- Trending Technology Slider -->
        <div id="trendingCarousel" class="mt-4 carousel slide" data-bs-ride="carousel">
          <h4 class="mt-4 fw-bold">🔥 Trending Technology</h4>
          <div class="carousel-inner mt-3">
            <div class="carousel-item active">
              <div class="d-flex gap-3">
                <div class="card flex-fill p-3 hover-shadow rounded-4 text-center">
                  <h6>🤖 Generative AI</h6>
                  <p class="small text-muted">Multimodal models transforming content creation</p>
                </div>
                <div class="card flex-fill p-3 hover-shadow rounded-4 text-center">
                  <h6>🖥️ TinyML</h6>
                  <p class="small text-muted">ML on edge devices for instant analytics</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="d-flex gap-3">
                <div class="card flex-fill p-3 hover-shadow rounded-4 text-center">
                  <h6>⚡ LLM Optimization</h6>
                  <p class="small text-muted">Techniques to make large language models efficient</p>
                </div>
                <div class="card flex-fill p-3 hover-shadow rounded-4 text-center">
                  <h6>🕶️ AR Collaboration</h6>
                  <p class="small text-muted">Augmented reality for team interactions</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Updated Carousel Controls with Font Awesome -->
          <button class="carousel-control-prev" type="button" data-bs-target="#trendingCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon-custom">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#trendingCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon-custom">
              <i class="fas fa-chevron-right"></i>
            </span>
            <span class="visually-hidden">Next</span>
          </button>

        </div>
      </div>
    </div>
  </section>

  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="icon-wrapper d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);">
          <i class="fa-solid fa-quote-left text-white fs-4 icon-pulse"></i>
        </div>
        <h2 class="h5 fw-bold text-dark mb-0">⚡ Quick Bytes</h2>
      </div>
      <button class="btn btn-gradient-action btn-sm shadow-sm hover-scale mt-3" data-bs-toggle="modal" data-bs-target="#modalQuote">
        Read Quote <i class="fa-solid fa-arrow-right ms-1"></i>
      </button>
    </div>
    <p class="text-muted small">“You won’t be replaced by AI—but by someone using it.”</p>

    <div class="row g-4">

      <!-- Card 1 -->
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="p-3 mb-2 bg-primary text-dark bg-opacity-10 rounded-2">
          <!-- <i class="fa-solid fa-robot ai-icon"></i> -->
          <h5 class="fw-semibold">Claude 3.56 Sonnet</h5>
          <small class="text-muted">Advanced reasoning and coding assistance</small>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="p-3 mb-2 bg-success text-dark bg-opacity-10 rounded-2">
          <!-- <i class="fa-solid fa-video ai-icon text-success"></i> -->
          <h5 class="fw-semibold">Runway ML Gen-3</h5>
          <small class="text-muted">Text-to-video generation made simple</small>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="p-3 mb-2 bg-warning text-dark bg-opacity-10 rounded-2">
          <!-- <i class="fa-solid fa-lightbulb ai-icon text-warning"></i> -->
          <h5 class="fw-semibold">Fathom & Notion</h5>
          <small class="text-muted">Helps reclaim up to 15 hours a week</small>
        </div>
      </div>




    </div>
  </section>

  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="icon-wrapper d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
          <i class="fa-solid fa-bolt text-white fs-4 icon-pulse"></i>
        </div>
        <h2 class="h5 fw-bold text-dark mb-0">AI Tip of the Week</h2>
      </div>


      <button class="btn btn-gradient-action btn-sm shadow-sm hover-scale mt-3" data-bs-toggle="modal" data-bs-target="#modalAITip">
        Try this tip <i class="fa-solid fa-arrow-right ms-1"></i>
      </button>
    </div>
    <p class="text-muted small">Instantly summarize meeting notes or brainstorm ideas using Notion AI.</p>

    <div class="row">
      <div class="col-md-6">
        <div class="p-3 mb-2  text-dark bg-opacity-25 rounded-2 " style="background-color: #eef6fe;">✨Boost your workflow with this week’s smartest AI hack.
        </div>


      </div>
      <div class="col-md-6">
        <div class="p-3 mb-2 bg-success text-dark bg-opacity-25 rounded-2">⚡Unlock productivity with a game-changing AI tip this week
        </div>
      </div>
    </div>
  </section>



  <!-- AI Spotlight Section -->
  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="icon-wrapper d-flex align-items-center justify-content-center rounded-circle shadow-sm"
          style="background: linear-gradient(135deg, #4a90e2 0%, #50e3c2 100%); width:50px; height:50px;">
          <i class="fa-solid fa-microchip text-white fs-4 icon-pulse"></i>
        </div>
        <h2 class="h5 fw-bold text-dark mb-0">AI Tools</h2>
      </div>

      <div class="d-flex justify-content-center align-items-center mt-3">
        <button class="btn-gradient-action btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAiSpotlight">
          Explore Tools <i class="fa-solid fa-arrow-right ms-1"></i>
        </button>

      </div>

    </div>
    <p class="text-muted small">
      Discover the latest AI tools that are transforming how we work and create.
    </p>

    <div class="row">
      <div class="col-md-6">
        <div class="p-3 mb-2  text-dark bg-opacity-25 rounded-2 " style="background-color: #eef6fe;"><strong>Manus (Autonomous AI Agent) </strong><br>
          <small>Manus paves the way for agentic, hands-off AI workflows.

          </small>
        </div>


      </div>
      <div class="col-md-6">
        <div class="p-3 mb-2 bg-success text-dark bg-opacity-25 rounded-2"><strong>Fathom (Multi-Model Workspace Platform)</strong> <br><small>Automatically records and summarizes Zoom calls for remote teams.

          </small>
        </div>
      </div>
    </div>
  </section>

  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="icon-wrapper d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);">
          <i class="fa-solid fa-tools text-white fs-4 icon-pulse"></i>
        </div>
        <h2 class="h5 fw-bold text-dark mb-0">Toolbox for Professionals</h2>
      </div>
      <button class="btn btn-gradient-action btn-sm shadow-sm hover-scale mt-3" data-bs-toggle="modal" data-bs-target="#modalToolbox">
        Explore Tools <i class="fa-solid fa-arrow-right ms-1"></i>
      </button>
    </div>
    <!-- <p class="text-muted small">Check out AI tools that help you manage tasks, meetings, and productivity.</p> -->
    <div class="row">
      <div class="col-md-6">
        <div class="p-3 mb-2  text-dark bg-opacity-25 rounded-2 " style="background-color: #eef6fe;"><strong>Notion AI (Artificial Intelligence):
          </strong> <br>
          <small> Notion AI turns your workspace into a smart hub.


          </small>
        </div>


      </div>
      <div class="col-md-6">
        <div class="p-3 mb-2 bg-success text-dark bg-opacity-25 rounded-2"><strong>Jasper AI Smart Personal Efficient Robot</strong> <br><small> Jasper makes content creation faster and sharper.


          </small>
        </div>
      </div>
    </div>
  </section>

  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="icon-wrapper d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);">
          <i class="fa-solid fa-chart-line text-white fs-4 icon-pulse"></i>
        </div>
        <h2 class="h5 fw-bold text-dark mb-0">Career Growth</h2>
      </div>
      <button class="btn btn-gradient-action btn-sm shadow-sm hover-scale mt-3" data-bs-toggle="modal" data-bs-target="#modalCareer">
        Grow with it <i class="fa-solid fa-arrow-right ms-1"></i>
      </button>
    </div>
    <p class="text-muted small">Nail your next pitch using the 3-30-3 rule: Hook in 3 seconds, build context in 30 seconds, and deliver key value in under 3 minutes. It’s how leaders hold attention and win buy-in.</p>
  </section>




  <section class="container bg-white rounded-4 shadow-lg p-4 border border-light mb-4">
    <!-- Header -->
    <div class="d-flex align-items-center gap-2 mb-3">
      <i class="fa-solid fa-quote-left text-primary"></i>
      <h6 class="fw-semibold text-dark mb-0">Quote to Reflect</h6>
    </div>

    <!-- Quote Slider -->
    <div id="quoteCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner">

        <!-- Quote 1 -->
        <div class="carousel-item active">
          <div class="p-3 bg-light rounded-3 shadow-sm border-start border-4" style="border-left-color: #f39c12 !important;">
            <p class="mb-1 fst-italic text-dark">
              “You won’t be replaced by AI—but by someone using it.”
            </p>
            <small class="text-muted">
              — A reminder: that tools don’t replace people. People using tools do.
            </small>
          </div>
        </div>

        <!-- Quote 2 -->
        <div class="carousel-item">
          <div class="p-3 bg-light rounded-3 shadow-sm border-start border-4" style="border-left-color: #f39c12 !important;">
            <p class="mb-1 fst-italic text-dark">
              “The best way to predict the future is to create it.”
            </p>
            <small class="text-muted">
              — Peter Drucker
            </small>
          </div>
        </div>

        <!-- Quote 3 -->
        <div class="carousel-item">
          <div class="p-3 bg-light rounded-3 shadow-sm border-start border-4" style="border-left-color: #f39c12 !important;">
            <p class="mb-1 fst-italic text-dark">
              “Innovation distinguishes between a leader and a follower.”
            </p>
            <small class="text-muted">
              — Steve Jobs
            </small>
          </div>
        </div>

        <!-- Quote 4 -->
        <div class="carousel-item">
          <div class="p-3 bg-light rounded-3 shadow-sm border-start border-4" style="border-left-color: #f39c12 !important;">
            <p class="mb-1 fst-italic text-dark">
              “Don’t watch the clock; do what it does. Keep going.”
            </p>
            <small class="text-muted">
              — Sam Levenson
            </small>
          </div>
        </div>

        <div class="carousel-controls-bottom">
          <button class="carousel-control-prev" type="button" data-bs-target="#quoteCarousel" data-bs-slide="prev">
            <span class="fa-solid fa-chevron-right fa-lg text-dark"></span>

          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#quoteCarousel" data-bs-slide="next">
            <span class="fa-solid fa-chevron-left fa-lg text-dark"></span>

          </button>
        </div>

      </div>
    </div>
  </section>



















  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4">
    <div>
      <p class="poll-title">Which AI tools would you like to learn more about next?</p>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="aiTools" id="ai1">
        <i class="bi bi-magic"></i>
        <label class="form-check-label" for="ai1">Generative AI tools for text/image/video</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="aiTools" id="ai2">
        <i class="bi bi-bar-chart"></i>
        <label class="form-check-label" for="ai2">AI for data analysis and dashboards</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="aiTools" id="ai3">
        <i class="bi bi-code-slash"></i>
        <label class="form-check-label" for="ai3">AI tools for coding assistance</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="aiTools" id="ai4">
        <i class="bi bi-pencil-square"></i>
        <label class="form-check-label" for="ai4">AI tools for content creation</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="aiTools" id="ai5">
        <i class="bi bi-chat-dots"></i>
        <label class="form-check-label" for="ai5">Other</label>
      </div>



      <button id="submitVote" class="btn btn-primary w-100 btn-gradient shadow-sm hover-scale">
        Submit Vote
      </button>
    </div>
  </section>
  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4">
    <div>
      <p class="poll-title">Which mental health topics interest you most for next time?</p>

      <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="mentalHealth" id="mh1">
        <label class="form-check-label" for="mh1">
          <i class="bi bi-emoji-smile"></i> Stress relief techniques
        </label>
      </div>

      <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="mentalHealth" id="mh2">
        <label class="form-check-label" for="mh2">
          <i class="bi bi-phone"></i> Apps for mindfulness and meditation
        </label>
      </div>

      <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="mentalHealth" id="mh3">
        <label class="form-check-label" for="mh3">
          <i class="bi bi-list-task"></i> Work-life balance tips
        </label>
      </div>

      <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="mentalHealth" id="mh4">
        <label class="form-check-label" for="mh4">
          <i class="bi bi-heart"></i> Emotional resilience at work
        </label>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="mentalHealth" id="mh5">
        <label class="form-check-label" for="mh5">
          <i class="bi bi-chat-dots"></i> Other
        </label>
      </div>

      <button class="btn btn-primary w-100 btn-gradient shadow-sm hover-scale">
        Submit Vote
      </button>



    </div>
  </section>
  <section class="container bg-white rounded-4 shadow-lg p-5 border border-light mb-4">
    <div>
      <p class="poll-title">What kind of productivity hacks would you like to explore?</p>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ph1">
        <i class="bi bi-clock"></i>
        <label class="form-check-label" for="ph1">Time management techniques</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ph2">
        <i class="bi bi-bullseye"></i>
        <label class="form-check-label" for="ph2">Focus and concentration tips</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ph3">
        <i class="bi bi-list-task"></i>
        <label class="form-check-label" for="ph3">Tools for task organization</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ph4">
        <i class="bi bi-house"></i>
        <label class="form-check-label" for="ph4">Work-from-home productivity ideas</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ph5">
        <i class="bi bi-chat-dots"></i>
        <label class="form-check-label" for="ph5">Other</label>
      </div>
      <button class="btn btn-primary w-100 btn-gradient shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#subscribeModal">
        Submit Vote
      </button>
    </div>
    <p class="thank-text mt-3">
      <strong>Thank you for your feedback!</strong> Your responses help us create more relevant and valuable content.
    </p>
  </section>


  <div class="modal fade" id="modalQuote" tabindex="-1" aria-labelledby="modalQuoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white fw-bold" id="modalQuoteLabel">
            <i class="bi bi-robot text-white me-2"></i> Featured AI Tools This Week
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <!-- Tool 1 -->
          <div class="border bg-primary text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold">1. Claude 3.5 Sonnet</h6>
            <p class="mb-2 text-muted">
              Advanced AI assistant for complex reasoning, coding, and creative tasks.
            </p>
            <span class="badge bg-primary">Text Generation</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Try Claude →</a>
          </div>

          <!-- Tool 2 -->
          <div class="border bg-success text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold">2. Runway ML Gen-3</h6>
            <p class="mb-2 text-muted">
              Create stunning videos from text prompts with generative AI video tech.
            </p>
            <span class="badge bg-warning text-dark">Video Generation</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Explore Runway →</a>
          </div>

          <!-- Tool 3 -->
          <div class="border bg-warning text-dark bg-opacity-10 rounded p-3">
            <h6 class="fw-semibold">3. Perplexity AI</h6>
            <p class="mb-2 text-muted">
              AI-powered search engine with accurate, real-time answers and cited sources.
            </p>
            <span class="badge bg-success">Research</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Search with Perplexity →</a>
          </div>

        </div>
      </div>
    </div>
  </div>



  <!-- Example Modal (Duplicate & Update IDs and Content for each section) -->
  <div class="modal fade" id="modalAITip" tabindex="-1" aria-labelledby="modalAITipLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-top modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white fw-bold" id="modalAITipLabel">
            <i class="bi bi-lightning-charge text-primary me-2"></i> AI Tip of the Week
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <!-- <div class="modal-body">


          <div class="border bg-primary text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold"><strong>Tip 1:</strong> Use AI for drafting emails & summaries — it saves 20–30 minutes daily.</h6>

          </div>


          <div class="border bg-success text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold"><strong>Tip 2:</strong> Combine AI note-taking tools with task managers to stay organized.</h6>

          </div>
          <div class="border bg-warning  text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold"><strong>Tip 3:</strong> Leverage AI image/video tools to create quick visuals for presentations and social posts.</h6>

          </div>

        </div> -->
        <div class="modal-body"> 

  <!-- AI Tip of the Week: Notion AI -->
  <div class="border bg-warning text-dark bg-opacity-10 rounded p-3 mb-3">
    <h6 class="fw-semibold">✨ AI Tip of the Week: Notion AI</h6>
    <p class="mb-2 text-muted">
      Save hours, not minutes. <br>
      Notion AI makes work faster, smarter, and stress-free.
    </p>
    <span class="badge bg-warning text-dark">Productivity Hack</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Try Notion AI →</a>

    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Use Notion AI to summarize long meeting notes instantly.</li>
      <li><strong>Tip 2:</strong> Let Notion AI generate action items so you focus on execution.</li>
    </ul>
  </div>

  <!-- AI Tip of the Week: Claude 3.5 -->
  <div class="border bg-info text-dark bg-opacity-10 rounded p-3 mb-3">
    <h6 class="fw-semibold">✨ AI Tip of the Week: Claude 3.5</h6>
    <p class="mb-2 text-muted">
      Draft smarter, code faster. <br>
      Claude helps with deep reasoning, summaries, and creative writing.
    </p>
    <span class="badge bg-info text-dark">AI Assistant</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Try Claude →</a>

    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Use Claude for instant research summaries.</li>
      <li><strong>Tip 2:</strong> Let Claude debug or explain code step by step.</li>
    </ul>
  </div>

  <!-- AI Tip of the Week: Gemini -->
  <div class="border bg-success text-dark bg-opacity-10 rounded p-3 mb-3">
    <h6 class="fw-semibold">✨ AI Tip of the Week: Gemini</h6>
    <p class="mb-2 text-muted">
      Google’s Gemini makes research, coding, and daily tasks easier with powerful AI integration.
    </p>
    <span class="badge bg-success text-dark">Research & Coding</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Try Gemini →</a>

    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Use Gemini to generate quick code snippets.</li>
      <li><strong>Tip 2:</strong> Let Gemini find insights from long documents instantly.</li>
    </ul>
  </div>

  <!-- AI Tip of the Week: Perplexity -->
  <div class="border bg-danger text-dark bg-opacity-10 rounded p-3 mb-3">
    <h6 class="fw-semibold">✨ AI Tip of the Week: Perplexity AI</h6>
    <p class="mb-2 text-muted">
      Get fact-based, cited answers fast. <br>
      Perplexity is your AI-powered research partner.
    </p>
    <span class="badge bg-danger text-light">Research</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Explore Perplexity →</a>

    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Use Perplexity to verify facts before reporting.</li>
      <li><strong>Tip 2:</strong> Ask complex multi-step questions for deeper insights.</li>
    </ul>
  </div>

  <!-- AI Tip of the Week: Runway Gen-3 -->
  <div class="border bg-primary text-dark bg-opacity-10 rounded p-3 mb-3">
    <h6 class="fw-semibold">✨ AI Tip of the Week: Runway Gen-3</h6>
    <p class="mb-2 text-muted">
      Create stunning videos from text prompts with generative AI video tech.
    </p>
    <span class="badge bg-primary">Video Creation</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Explore Runway →</a>

    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Turn campaign ideas into videos in minutes.</li>
      <li><strong>Tip 2:</strong> Use Runway for quick social media ads.</li>
    </ul>
  </div>

  <!-- AI Tip of the Week: Synthesia -->
  <div class="border bg-secondary text-dark bg-opacity-10 rounded p-3 mb-0">
    <h6 class="fw-semibold">✨ AI Tip of the Week: Synthesia</h6>
    <p class="mb-2 text-muted">
      Turn text into professional AI avatar videos—no cameras, no studios needed.
    </p>
    <span class="badge bg-secondary text-light">AI Video</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Try Synthesia →</a>

    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Create training videos in minutes with AI avatars.</li>
      <li><strong>Tip 2:</strong> Localize your videos by generating multiple language versions.</li>
    </ul>
  </div>

</div>


      </div>
    </div>
  </div>

  <!-- Repeat modals for Toolbox, Career, Wellness, Quote -->
  <div class="modal fade" id="modalToolbox" tabindex="-1" aria-labelledby="modalToolboxLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white fw-bold" id="modalToolboxLabel">
            <i class="bi bi-tools text-success me-2"></i> Toolbox for Professionals
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <!-- Toolbox 1 -->
          <div class="border bg-warning text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold">Toolbox 1: Notion AI</h6>
            <p class="mb-2 text-muted">
              An all-in-one workspace powered with AI to create docs, manage projects, and brainstorm ideas faster.
            </p>
            <span class="badge bg-warning text-dark">Productivity</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Explore Notion AI →</a>

            <!-- Tips -->
            <ul class="mt-3 mb-0 text-muted small">
              <li><strong>Tip 1:</strong> Use AI to summarize meeting notes instantly.</li>
              <li><strong>Tip 2:</strong> Generate action items from project discussions automatically.</li>
            </ul>
          </div>

          <!-- Toolbox 2 -->
          <div class="border bg-danger text-dark bg-opacity-10 rounded p-3 mb-0">
            <h6 class="fw-semibold">Toolbox 2: Jasper</h6>
            <p class="mb-2 text-muted">
              AI-powered writing assistant for blogs, marketing copy, and social media posts.
            </p>
            <span class="badge bg-danger text-light">Content Creation</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Try Jasper →</a>

            <!-- Tips -->
            <ul class="mt-3 mb-0 text-muted small">
              <li><strong>Tip 1:</strong> Create SEO-friendly blog drafts in minutes.</li>
              <li><strong>Tip 2:</strong> Use Jasper’s templates for ads, emails, and social media posts.</li>
            </ul>
          </div>

        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCareer" tabindex="-1" aria-labelledby="modalCareerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white fw-bold" id="modalCareerLabel">
            <i class="bi bi-graph-up text-white me-2"></i> Career Growth
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body"> 

  <!-- Career Growth -->
  <div class="border bg-light text-dark bg-opacity-50 rounded p-3 mb-3">
    <h6 class="fw-semibold">🚀 Career Growth</h6>
    <p class="mb-2 text-muted">
      2025 me sabse zyada demand <strong>AI, Data Science, Cybersecurity, aur Cloud Computing</strong> fields me hai.  
      In skills par focus karke aap apni career growth ko fast-track kar sakte ho.
    </p>
    <span class="badge bg-primary text-light">AI</span>
    <span class="badge bg-warning text-dark">Data Science</span>
    <span class="badge bg-success text-light">Cybersecurity</span>
    <span class="badge bg-info text-dark">Cloud</span>
    <a href="#" class="ms-2 small text-primary text-decoration-none">Explore more →</a>

    <!-- Tips -->
    <ul class="mt-3 mb-0 text-muted small">
      <li><strong>Tip 1:</strong> Start with AI tools and frameworks like TensorFlow, PyTorch, or OpenAI APIs.</li>
      <li><strong>Tip 2:</strong> Build projects in Data Science or Cybersecurity to showcase real-world skills.</li>
      <li><strong>Tip 3:</strong> Get certified in Cloud platforms (AWS, Azure, GCP) for better opportunities.</li>
    </ul>
  </div>

</div>


      </div>
    </div>
  </div>

  <div class="modal fade" id="modalWellness" tabindex="-1" aria-labelledby="modalWellnessLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white">Wellness & Mindfulness</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <h6>Tip 1</h6>
              <p>Quick wellness advice for daily routine.</p>
              <a href="#" class="small">Read more →</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalAiSpotlight" tabindex="-1" aria-labelledby="modalAiSpotlightLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadowt">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white fw-bold" id="modalAiSpotlightLabel">
            <i class="bi bi-quote text-white me-2"></i> AI Tools

          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>“You won’t be replaced by AI—but by someone using it.” — A reminder that tools don’t replace people.</p>
          <div class="border bg-info text-dark bg-opacity-10 rounded p-3 mb-3">
            <h6 class="fw-semibold">1. Motion</h6>
            <p class="mb-2 text-muted">
              An AI calendar that adapts to your day and helps prioritize deep work blocks.
            </p>
            <span class="badge bg-info text-dark">Calendar & Scheduling</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Try Motion →</a>

            <ul class="mt-3 mb-0 text-muted small">
              <li><strong>Tip 1:</strong> Block 90–120 min “deep work” slots daily—Motion auto-reschedules meetings around them.</li>
              <li><strong>Tip 2:</strong> Enable deadline-aware tasks so urgent items float to the top automatically.</li>
            </ul>
          </div>

          <!-- Tool 4 -->
          <div class="border bg-secondary text-dark bg-opacity-10 rounded p-3 mb-0">
            <h6 class="fw-semibold">2. Fathom</h6>
            <p class="mb-2 text-muted">
              Automatically records and summarizes Zoom calls—perfect for remote teams.
            </p>
            <span class="badge bg-secondary text-light">Meetings & Notes</span>
            <a href="#" class="ms-2 small text-primary text-decoration-none">Explore Fathom →</a>

            <ul class="mt-3 mb-0 text-muted small">
              <li><strong>Tip 1:</strong> Send the auto-generated summary to Slack/Email to keep everyone aligned.</li>
              <li><strong>Tip 2:</strong> Use timestamped highlights to turn decisions into actionable tasks.</li>
            </ul>
          </div>



        </div>
      </div>
    </div>
  </div>






  </section>

  <?php include __DIR__ . '/../inc/footer.php'; ?>

  <!-- Subscribe Modal -->
<div class="modal fade" id="subscribeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 rounded-3 shadow">
      <div class="modal-header" style="background:var(--brand1)">
        <h5 class="modal-title text-white">Subscribe</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="subscribeForm" action="<?= htmlspecialchars($BASE_URL . '/public/subscribe.php') ?>" method="post">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" required class="form-control" />
          </div>
          <button type="submit" class="btn btn-primary w-100">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- AI Tools Modal -->
  <div class="modal fade" id="aiToolsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-top modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header" style="background:var(--accent);">
          <h5 class="modal-title text-white">New AI Tools — This Week</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

        <!-- Tool 1 -->
        <div class="border bg-primary text-dark bg-opacity-10 rounded p-3 mb-3">
          <h6 class="fw-semibold">1. GitHub Copilot</h6>
          <p class="mb-2 text-muted">
            AI pair programmer that suggests code completions and entire functions directly in your IDE.
          </p>
          <span class="badge bg-primary">Code Generation</span>
          <a href="https://github.com/features/copilot" target="_blank" class="ms-2 small text-primary text-decoration-none">Try Copilot →</a>
        </div>

        <!-- Tool 2 -->
        <div class="border bg-success text-dark bg-opacity-10 rounded p-3 mb-3">
          <h6 class="fw-semibold">2. Tabnine</h6>
          <p class="mb-2 text-muted">
            AI code completion tool that learns your coding patterns and boosts development speed.
          </p>
          <span class="badge bg-success">Code Assistant</span>
          <a href="https://www.tabnine.com/" target="_blank" class="ms-2 small text-primary text-decoration-none">Explore Tabnine →</a>
        </div>

        <!-- Tool 3 -->
        <div class="border bg-warning text-dark bg-opacity-10 rounded p-3 mb-3">
          <h6 class="fw-semibold">3. Replit Ghostwriter</h6>
          <p class="mb-2 text-muted">
            Smart AI coding companion inside Replit, offering code suggestions, explanations, and debugging help.
          </p>
          <span class="badge bg-warning text-dark">IDE Assistant</span>
          <a href="https://replit.com/site/ghostwriter" target="_blank" class="ms-2 small text-primary text-decoration-none">Use Ghostwriter →</a>
        </div>

        <!-- Tool 4 -->
        <div class="border bg-info text-dark bg-opacity-10 rounded p-3">
          <h6 class="fw-semibold">4. Codeium</h6>
          <p class="mb-2 text-muted">
            Free AI-powered code acceleration tool that supports 70+ languages and multiple IDEs.
          </p>
          <span class="badge bg-info">Code Acceleration</span>
          <a href="https://codeium.com/" target="_blank" class="ms-2 small text-primary text-decoration-none">Check Codeium →</a>
        </div>

      </div>
    </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- ✅ SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 5 sec baad modal open hoga
    setTimeout(function() {
      var subscribeModal = new bootstrap.Modal(document.getElementById('subscribeModal'));
      subscribeModal.show();
    }, 5000); 

    // ✅ Form submit event
    document.getElementById("subscribeForm").addEventListener("submit", function(e) {
      e.preventDefault(); // form ko manually handle karenge

      if (this.checkValidity()) { 
        // Agar form valid hai
        var subscribeModal = bootstrap.Modal.getInstance(document.getElementById('subscribeModal'));
        subscribeModal.hide();

        Swal.fire({
          title: '✅ Thank You!',
          text: 'You have successfully subscribed.',
          icon: 'success',
          confirmButtonColor: '#f89852'
        });

        // ✅ Agar backend par bhejna ho to uncomment kijiye:
        this.submit();
      } else {
        // Agar form invalid hai to browser validation trigger karega
        this.reportValidity();
      }
    });
  });
</script>




  <script>
    document.getElementById("submitVote").addEventListener("click", function() {
      Swal.fire({
        title: '✅ Thank You!',
        text: 'Your vote has been submitted successfully.',
        icon: 'success',
        confirmButtonColor: '#f89852'
      });
    });
  </script>



</body>

</html>